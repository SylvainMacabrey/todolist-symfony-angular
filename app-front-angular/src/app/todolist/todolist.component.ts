import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { TodolistService } from '../services/todolist.service';

@Component({
  selector: 'app-todolist',
  templateUrl: './todolist.component.html',
  styleUrls: ['./todolist.component.css']
})
export class TodolistComponent implements OnInit {

  public todolists: [];
  public filterUser: string = '';
  public filterIsComplete: boolean;

  constructor(private router: Router, private todoListService: TodolistService) { }

  ngOnInit(): void {
    this.getTodoLists();
  }

  getTodoLists() {
    this.todoListService.findAllTodolists(this.filterUser, this.filterIsComplete).subscribe(
      response => {
        this.todolists = response["todolists"];
    });
  }

  onChangeFiltreIsComplete(filtreIsComplete: boolean) {
    this.filterIsComplete = filtreIsComplete;
    this.getTodoLists();
  }

  onChangeFiltreUser(event) {
    this.filterUser = event.target.value;
    this.getTodoLists();
  }

  logout() {
    localStorage.removeItem("jwt");
    this.router.navigate(['login']);
  }

}
