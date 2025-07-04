import { Component, OnInit } from '@angular/core';
import { Observable } from 'rxjs';
import { OrderService } from '../../services/order.service';
import { Order } from '../../models/order.model';

@Component({
  selector: 'app-order-list',
  templateUrl: './order-list.component.html',
  styleUrls: ['./order-list.component.scss']
})
export class OrderListComponent implements OnInit {
  orders$: Observable<Order[]>;
  loading = true;
  displayedColumns: string[] = ['reference', 'date', 'status', 'items', 'total', 'actions'];

  constructor(private orderService: OrderService) {
    this.orders$ = new Observable();
  }

  ngOnInit(): void {
    this.loadOrders();
  }

  loadOrders(): void {
    this.loading = true;
    this.orders$ = this.orderService.getOrders();
    this.loading = false;
  }

  getStatusColor(status: string): string {
    switch (status) {
      case 'pending': return 'orange';
      case 'confirmed': return 'blue';
      case 'shipped': return 'purple';
      case 'delivered': return 'green';
      case 'cancelled': return 'red';
      default: return 'gray';
    }
  }

  getStatusText(status: string): string {
    switch (status) {
      case 'pending': return 'En attente';
      case 'confirmed': return 'Confirmée';
      case 'shipped': return 'Expédiée';
      case 'delivered': return 'Livrée';
      case 'cancelled': return 'Annulée';
      default: return status;
    }
  }

  getItemsCount(order: Order): number {
    return order.orderItems.reduce((count, item) => count + item.quantity, 0);
  }
}