import { Component, Input } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { Product } from '../../models/product.model';
import { CartService } from '../../services/cart.service';
import { CartPopupComponent, CartPopupData } from '../cart-popup/cart-popup.component';

@Component({
  selector: 'app-product-card',
  templateUrl: './product-card.component.html',
  styleUrls: ['./product-card.component.scss']
})
export class ProductCardComponent {
  @Input() product!: Product;

  constructor(
    private cartService: CartService,
    private dialog: MatDialog
  ) {}

  addToCart(): void {
    if (this.product.stock > 0) {
      const quantity = 1;
      this.cartService.addToCart(this.product, quantity);
      
      const dialogData: CartPopupData = {
        product: this.product,
        quantity: quantity
      };
      
      this.dialog.open(CartPopupComponent, {
        data: dialogData,
        panelClass: 'cart-popup-dialog',
        maxWidth: 'calc(100vw - 32px)',
        width: 'auto',
        maxHeight: '95vh',
        autoFocus: false,
        restoreFocus: false,
        hasBackdrop: true,
        disableClose: false
      });
    }
  }

  getImageUrl(): string {
    return this.product.image || 'assets/images/no-image.png';
  }

  getStockText(): string {
    if (this.product.stock === 0) {
      return 'Rupture';
    } else if (this.product.stock < 5) {
      return `Stock faible (${this.product.stock})`;
    } else {
      return `En stock (${this.product.stock})`;
    }
  }
}