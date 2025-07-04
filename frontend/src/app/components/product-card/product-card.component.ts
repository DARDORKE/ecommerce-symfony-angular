import { Component, Input } from '@angular/core';
import { MatSnackBar } from '@angular/material/snack-bar';
import { Product } from '../../models/product.model';
import { CartService } from '../../services/cart.service';

@Component({
  selector: 'app-product-card',
  templateUrl: './product-card.component.html',
  styleUrls: ['./product-card.component.scss']
})
export class ProductCardComponent {
  @Input() product!: Product;

  constructor(
    private cartService: CartService,
    private snackBar: MatSnackBar
  ) {}

  addToCart(): void {
    if (this.product.stock > 0) {
      this.cartService.addToCart(this.product, 1);
      this.snackBar.open('Produit ajouté au panier', 'Fermer', {
        duration: 2000,
        horizontalPosition: 'right',
        verticalPosition: 'top'
      });
    }
  }

  getImageUrl(): string {
    return this.product.image || 'assets/images/no-image.png';
  }
}