import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  template: `
    <app-header></app-header>
    <main class="container-fluid">
      <router-outlet></router-outlet>
    </main>
  `,
  styles: [`
    main {
      padding-top: 96px;
      min-height: 100vh;
      background-color: var(--gray-50);
      
      @media (max-width: 768px) {
        padding-top: 80px;
      }
    }
  `]
})
export class AppComponent {
  title = 'E-commerce App';
}