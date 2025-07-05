import { Component, OnInit } from '@angular/core';
import { Observable } from 'rxjs';
import { ProductService } from '../../services/product.service';
import { Product } from '../../models/product.model';

@Component({
  selector: 'app-product-list',
  templateUrl: './product-list.component.html',
  styleUrls: ['./product-list.component.scss']
})
export class ProductListComponent implements OnInit {
  products$: Observable<Product[]>;
  categories$: Observable<string[]>;
  selectedCategory: string = '';
  searchTerm: string = '';
  sortBy: string = '';
  loading = false;

  constructor(private productService: ProductService) {
    this.products$ = new Observable();
    this.categories$ = this.productService.getCategories();
  }

  ngOnInit(): void {
    this.loadProducts();
  }

  loadProducts(): void {
    this.loading = true;
    this.products$ = this.productService.getProducts(
      this.selectedCategory || undefined,
      this.searchTerm || undefined
    );
    this.loading = false;
  }

  onCategoryChange(category: string): void {
    this.selectedCategory = category;
    this.loadProducts();
  }

  onSearch(): void {
    this.loadProducts();
  }

  onSortChange(sortBy: string): void {
    this.sortBy = sortBy;
    this.loadProducts();
  }

  clearFilters(): void {
    this.selectedCategory = '';
    this.searchTerm = '';
    this.sortBy = '';
    this.loadProducts();
  }

  clearSearch(): void {
    this.searchTerm = '';
    this.loadProducts();
  }

  hasActiveFilters(): boolean {
    return !!(this.searchTerm || this.selectedCategory || this.sortBy);
  }

  trackByProductId(index: number, product: Product): number {
    return product.id;
  }
}