import { Product } from './product.model';
import { User } from './user.model';

export interface Order {
  id: number;
  reference: string;
  status: string;
  totalAmount: number;
  createdAt: string;
  user: User;
  orderItems: OrderItem[];
}

export interface OrderItem {
  id: number;
  quantity: number;
  price: number;
  product: Product;
}

export interface OrderCreateRequest {
  items: {
    productId: number;
    quantity: number;
  }[];
}

export interface CartItem {
  product: Product;
  quantity: number;
}