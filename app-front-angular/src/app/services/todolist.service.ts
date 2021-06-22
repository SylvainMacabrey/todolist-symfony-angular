import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class TodolistService {

  private url = 'http://127.0.0.1:8000/api';
  private token: string = '';

  constructor(private httpClient: HttpClient) { }

  findAllTodolists(filterUser: string, filterIsComplete?: boolean) {
    var filter = `?filterUser=${ filterUser }`;
    if(filterIsComplete) {
      filter += `&filterIsComplete=${ filterIsComplete }`;
    }
    return this.httpClient.get(`${ this.url }/todolists${ filter }`).pipe(
      map(response => {
          if (response) {
              return response;
          }
      }));
  }

  addTodolist(todolist) {
    var todolistBody = {};
    todolistBody["title"] = todolist.title;
    todolistBody["tasks"] = [];
    todolist.tasks.forEach(task => {
      todolistBody["tasks"].push({ "name": task })
    });
    console.log(todolistBody);
    return this.httpClient.post(`${ this.url }/todolist/create`, todolistBody);
  }

  updateTask(idTask, isComplete?: boolean, name?: string) {
    var taskBody = {};
    if(typeof isComplete !== 'undefined') {
      taskBody["isComplete"] = isComplete;
    }
    if(typeof name !== 'undefined') {
      taskBody["name"] = name;
    }
    return this.httpClient.put(`${ this.url }/task/update/${ idTask }`, taskBody);
  }

  deleteTodolist(idTodolist) {
    return this.httpClient.delete(`${ this.url }/todolist/delete/${ idTodolist }`);
  }

  deleteTask(idTask) {
    return this.httpClient.delete(`${ this.url }/task/delete/${ idTask }`);
  }

}
