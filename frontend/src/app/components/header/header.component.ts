import { Component, OnInit, ElementRef } from '@angular/core';
import { Router } from '@angular/router';
import { Observable } from 'rxjs';
import { AuthService } from '../../services/auth.service';
import { CartService } from '../../services/cart.service';
import { User } from '../../models/user.model';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent implements OnInit {
  currentUser$: Observable<User | null>;
  cartItemCount$: Observable<number>;

  constructor(
    private authService: AuthService,
    private cartService: CartService,
    private router: Router,
    private elementRef: ElementRef
  ) {
    this.currentUser$ = this.authService.currentUser$;
    this.cartItemCount$ = this.cartService.getCartItemCount();
  }

  ngOnInit(): void {}

  logout(): void {
    this.authService.logout();
    this.router.navigate(['/']);
  }

  getUserDisplayName(user: User): string {
    if (user.firstName) {
      return user.firstName;
    }
    if (user.email) {
      return user.email.split('@')[0];
    }
    return 'Utilisateur';
  }

  closeNavbar(): void {
    const navbarCollapse = this.elementRef.nativeElement.querySelector('#navbarNav');
    if (navbarCollapse && navbarCollapse.classList.contains('show')) {
      const bsCollapse = new (window as any).bootstrap.Collapse(navbarCollapse, {
        toggle: false
      });
      bsCollapse.hide();
    }
  }

  onNavClick(): void {
    this.closeNavbar();
  }
}