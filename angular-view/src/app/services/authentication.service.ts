import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders, HttpResponse} from "@angular/common/http";
import {Observable} from "rxjs";
import {UserInterface} from "../interfaces/user";
import "rxjs-compat/add/operator/map";
import {environment} from "../../environments/environment";
import {map} from "rxjs/operators";

const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type':  'application/json',
  })
};

@Injectable({
  providedIn: 'root'
})
export class AuthenticationService {
  private apiUrl: string;

  constructor(private http: HttpClient) {}

  login(username: string, password: string) {
    return this.http.post<any>(environment.apiUrl + '/api/login', { username, password }, httpOptions)
        .pipe(map(user => {
          // login successful if there's a user in the response
          if (user) {
            // store user details and basic auth credentials in local storage
            // to keep user logged in between page refreshes
            user.authdata = window.btoa(username + ':' + password);
            localStorage.setItem('currentUser', JSON.stringify(user));
          }

          return user;
        }));
  }

  isAuthenticated() {
      return localStorage.getItem("currentUser") != null;
  }

  logout() {
      localStorage.removeItem('userToken');
      localStorage.removeItem('currentUser');
  }
}
