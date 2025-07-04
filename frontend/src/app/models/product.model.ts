export interface Product {
  id: number;
  name: string;
  description: string;
  price: number;
  image?: string;
  category: string;
  stock: number;
  active: boolean;
  createdAt: string;
}

export interface ProductCreateRequest {
  name: string;
  description: string;
  price: number;
  image?: string;
  category: string;
  stock: number;
}