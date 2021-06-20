import { Component, OnInit } from '@angular/core';
import { AuthService } from '../services/auth.service';
import { NgForm } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  public email: string;
  public password: string;
  public errors: [];

  constructor(private authService: AuthService, private router: Router) { }

  ngOnInit(): void {

  }

  login(form: NgForm) {
    this.authService.login(form.value.email,form.value.password).subscribe(
      response => { 
        this.router.navigate(['todolist']);
      },
      error => {
        console.log(error);
        this.errors = error;
      }
    );
  }

}
