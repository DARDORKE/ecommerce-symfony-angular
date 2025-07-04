import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { MatSnackBar } from '@angular/material/snack-bar';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {
  registerForm: FormGroup;
  loading = false;
  hidePassword = true;

  constructor(
    private fb: FormBuilder,
    private authService: AuthService,
    private router: Router,
    private snackBar: MatSnackBar
  ) {
    this.registerForm = this.fb.group({
      firstName: ['', [Validators.required, Validators.minLength(2)]],
      lastName: ['', [Validators.required, Validators.minLength(2)]],
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required, Validators.minLength(6)]]
    });
  }

  ngOnInit(): void {
    // Rediriger si déjà connecté
    if (this.authService.isLoggedIn()) {
      this.router.navigate(['/']);
    }
  }

  onSubmit(): void {
    if (this.registerForm.valid) {
      this.loading = true;
      this.authService.register(this.registerForm.value).subscribe({
        next: (user) => {
          this.snackBar.open('Inscription réussie! Vous pouvez maintenant vous connecter.', 'Fermer', { duration: 3000 });
          this.router.navigate(['/login']);
          this.loading = false;
        },
        error: (error) => {
          console.error('Erreur d\'inscription:', error);
          const message = error.error?.message || 'Erreur lors de l\'inscription';
          this.snackBar.open(message, 'Fermer', { duration: 3000 });
          this.loading = false;
        }
      });
    }
  }

  getErrorMessage(field: string): string {
    const control = this.registerForm.get(field);
    if (control?.hasError('required')) {
      const fieldNames: { [key: string]: string } = {
        firstName: 'Prénom',
        lastName: 'Nom',
        email: 'Email',
        password: 'Mot de passe'
      };
      return `${fieldNames[field]} requis`;
    }
    if (control?.hasError('email')) {
      return 'Email invalide';
    }
    if (control?.hasError('minlength')) {
      const minLength = control.getError('minlength').requiredLength;
      return `Minimum ${minLength} caractères requis`;
    }
    return '';
  }
}