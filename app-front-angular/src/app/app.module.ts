import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { TodolistComponent } from './todolist/todolist.component';
import { AddTodolistComponent } from './add-todolist/add-todolist.component';
import { AuthService } from './services/auth.service';
import { TodolistService } from './services/todolist.service';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { JwtInterceptor } from './services/jwt.interceptor';


@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    TodolistComponent,
    AddTodolistComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule
  ],
  providers: [
    AuthService,
    TodolistService,
    { provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi:true },
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
