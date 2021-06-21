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
  public userid: number;

  constructor(private router: Router, private todoListService: TodolistService) { }

  ngOnInit(): void {
    this.getTodoLists();
  }

  public localStorageItem(id: string): string {
    return localStorage.getItem(id);
  }

  getTodoLists(): void {
    this.todoListService.findAllTodolists(this.filterUser, this.filterIsComplete).subscribe(
      response => {
        this.todolists = response["todolists"];
    });
  }

  onChangeFiltreIsComplete(filtreIsComplete: boolean): void {
    this.filterIsComplete = filtreIsComplete;
    this.getTodoLists();
  }

  onChangeFiltreUser(event): void {
    this.filterUser = event.target.value;
    this.getTodoLists();
  }

  onChangeTaskIsComplete(idTask, isComplete): void {
    this.todoListService.updateTask(idTask, isComplete).subscribe(
      response => {
        console.log(response);
      }
    );
  }

}
