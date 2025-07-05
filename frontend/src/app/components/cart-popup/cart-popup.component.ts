import { Component, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { Router } from '@angular/router';
import { map } from 'rxjs/operators';
import { Product } from '../../models/product.model';
import { CartService } from '../../services/cart.service';

export interface CartPopupData {
  product: Product;
  quantity: number;
}

@Component({
  selector: 'app-cart-popup',
  templateUrl: './cart-popup.component.html',
  styleUrls: ['./cart-popup.component.scss']
})
export class CartPopupComponent {
  cartItemCount$ = this.cartService.getCartItemCount();
  cartTotal$ = this.cartService.cartItems$.pipe(
    map(items => items.reduce((total, item) => total + (parseFloat(item.product.price) * item.quantity), 0))
  );

  constructor(
    public dialogRef: MatDialogRef<CartPopupComponent>,
    @Inject(MAT_DIALOG_DATA) public data: CartPopupData,
    private cartService: CartService,
    private router: Router
  ) {}

  onClose(): void {
    this.dialogRef.close();
  }

  goToCart(): void {
    this.dialogRef.close();
    this.router.navigate(['/cart']);
  }

  continueShopping(): void {
    this.dialogRef.close();
  }

  getImageUrl(): string {
    return this.data.product.image || 'assets/images/no-image.png';
  }
}