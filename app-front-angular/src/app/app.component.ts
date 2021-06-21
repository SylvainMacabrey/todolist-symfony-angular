import { Component } from '@angular/core';
import { Router } from '@angular/router';


@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'app-front-angular';

  constructor(private router: Router) { }

  public localStorageItem(id: string): string {
    return localStorage.getItem(id);
  }

  logout() {
    localStorage.removeItem("jwt");
    localStorage.removeItem("username");
    this.router.navigate(['login']);
  }

}
