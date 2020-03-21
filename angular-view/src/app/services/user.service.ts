import { Injectable } from '@angular/core';
import {HttpClient, HttpResponse} from '@angular/common/http';
import {UserInterface} from '../interfaces/user';
import {Observable} from 'rxjs';
import {environment} from '../../environments/environment';

@Injectable()
export class UserService {
  private apiUrl: string;

  constructor(private http: HttpClient) {
    this.apiUrl = environment.apiUrl + '/users';
  }

  getUsers() {
    return this.http.get<UserInterface>(this.apiUrl);
  }

  getUsersFull(): Observable<HttpResponse<UserInterface>> {
    return this.http.get<UserInterface>(
        this.apiUrl,
        { observe: 'response' }
    );
  }
}
