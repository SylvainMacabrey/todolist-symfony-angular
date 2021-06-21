import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class TodolistService {

  private url = 'http://127.0.0.1:8000/api';
  private token: string = '';
  private headers: HttpHeaders;

  constructor(private httpClient: HttpClient) {
    this.init();
  }

  async init() {
    this.token = await localStorage.getItem('jwt');
    this.headers = new HttpHeaders({
        Authorization: 'Bearer ' + this.token
    });
  }

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
}
