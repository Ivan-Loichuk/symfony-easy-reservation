import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {Router} from '@angular/router';
import {AuthenticationService} from '../../services/authentication.service';
import { first } from 'rxjs/operators';
import {HttpErrorResponse} from "@angular/common/http";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.less']
})
export class LoginComponent implements OnInit {
  public loginForm: FormGroup;
  public registrationForm: FormGroup;

  public errorMessage: string;

  constructor(
      private route: Router,
      private fb: FormBuilder,
      private authenticationService: AuthenticationService
  ) {

    this.loginForm = fb.group({
      email: ['', Validators.required],
      password: ['', Validators.required],
    });

    this.registrationForm = fb.group({
      email: ['', Validators.required],
    });
  }

  ngOnInit(): void {
  }

  onSignIn(credentials) {
    this.authenticationService.login(credentials.email, credentials.password)
        .pipe(first())
        .subscribe((data : any) => {
            localStorage.setItem('userToken', data.authdata);
            this.route.navigate(['/panel', data.user]);
        }, (err : HttpErrorResponse) => {
                this.errorMessage = err.error.error;
        });
  }

  onSignUp(credentials) {
    console.log(credentials);
  }

}
