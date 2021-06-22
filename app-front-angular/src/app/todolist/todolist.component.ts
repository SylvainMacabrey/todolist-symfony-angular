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

  constructor(private router: Router, private todolistService: TodolistService) { }

  ngOnInit(): void {
    this.getTodolists();
  }

  public localStorageItem(id: string): string {
    return localStorage.getItem(id);
  }

  getTodolists(): void {
    this.todolistService.findAllTodolists(this.filterUser, this.filterIsComplete).subscribe(
      response => {
        this.todolists = response["todolists"];
    });
  }

  onChangeFiltreIsComplete(filtreIsComplete: boolean): void {
    this.filterIsComplete = filtreIsComplete;
    this.getTodolists();
  }

  onChangeFiltreUser(event): void {
    this.filterUser = event.target.value;
    this.getTodolists();
  }

  onChangeTaskIsComplete(idTask, isComplete): void {
    this.todolistService.updateTask(idTask, isComplete).subscribe(
      response => {
        console.log(response);
      }
    );
  }

  deleteTodolist(idTodolist): void {
    this.todolistService.deleteTodolist(idTodolist).subscribe(
      response => {
        console.log(response);
        this.getTodolists();
      }
    );
  }

  deleteTask(idTask): void {
    this.todolistService.deleteTask(idTask).subscribe(
      response => {
        console.log(response);
        this.getTodolists();
      }
    );
  }

}
