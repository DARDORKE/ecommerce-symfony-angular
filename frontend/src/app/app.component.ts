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
      padding-top: 80px;
      min-height: 100vh;
    }
  `]
})
export class AppComponent {
  title = 'E-commerce App';
}