import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Observable } from 'rxjs';
import { MatSnackBar } from '@angular/material/snack-bar';
import { CartService } from '../../services/cart.service';
import { OrderService } from '../../services/order.service';
import { AuthService } from '../../services/auth.service';
import { CartItem, OrderCreateRequest } from '../../models/order.model';

@Component({
  selector: 'app-cart',
  templateUrl: './cart.component.html',
  styleUrls: ['./cart.component.scss']
})
export class CartComponent implements OnInit {
  cartItems$: Observable<CartItem[]>;
  total$: Observable<number>;
  loading = false;

  constructor(
    private cartService: CartService,
    private orderService: OrderService,
    private authService: AuthService,
    private router: Router,
    private snackBar: MatSnackBar
  ) {
    this.cartItems$ = this.cartService.cartItems$;
    this.total$ = new Observable(observer => {
      this.cartService.cartItems$.subscribe(() => {
        observer.next(this.cartService.getCartTotal());
      });
    });
  }

  ngOnInit(): void {}

  updateQuantity(productId: number, quantity: number): void {
    this.cartService.updateQuantity(productId, quantity);
  }

  removeItem(productId: number): void {
    this.cartService.removeFromCart(productId);
    this.snackBar.open('Produit retiré du panier', 'Fermer', { duration: 2000 });
  }

  clearCart(): void {
    this.cartService.clearCart();
    this.snackBar.open('Panier vidé', 'Fermer', { duration: 2000 });
  }

  checkout(): void {
    if (!this.authService.isLoggedIn()) {
      this.router.navigate(['/login']);
      return;
    }

    const items = this.cartService.getCartItems();
    if (items.length === 0) {
      this.snackBar.open('Le panier est vide', 'Fermer', { duration: 2000 });
      return;
    }

    this.loading = true;
    const orderData: OrderCreateRequest = {
      items: items.map(item => ({
        productId: item.product.id,
        quantity: item.quantity
      }))
    };

    this.orderService.createOrder(orderData).subscribe({
      next: (order) => {
        this.cartService.clearCart();
        this.snackBar.open('Commande créée avec succès!', 'Fermer', { duration: 3000 });
        this.router.navigate(['/orders']);
        this.loading = false;
      },
      error: (error) => {
        console.error('Erreur lors de la création de la commande:', error);
        this.snackBar.open('Erreur lors de la création de la commande', 'Fermer', { duration: 3000 });
        this.loading = false;
      }
    });
  }
}