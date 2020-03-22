import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from "@angular/forms";
import {Router} from "@angular/router";
import {AuthenticationService} from "../../services/authentication.service";
import { first } from 'rxjs/operators';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.less']
})
export class LoginComponent implements OnInit {
  public loginForm: FormGroup;
  public registrationForm: FormGroup;

  public errorMessage: string;
  public showErrorMessage: boolean = false;
  public showLoginMessage: boolean = false;
  public spinnerInShow = false;
  public spinnerUpShow = false;

  constructor(
      private route: Router,
      private fb:FormBuilder,
      private authenticationService: AuthenticationService
  ) {

    this.loginForm = fb.group({
      email: ["", Validators.required],
      password: ["", Validators.required],
    });

    this.registrationForm = fb.group({
      email: ["", Validators.required],
    });
  }

  ngOnInit(): void {
  }

  onSignIn(credentials) {
    console.log(credentials);

    this.authenticationService.login(credentials.email, credentials.password)
        .pipe(first())
        .subscribe(
            data => {
              console.log("success");
              //this.router.navigate([this.returnUrl]);
            },
            error => {
              console.log(error);
            });
  }

  onSignUp(credentials) {
    console.log(credentials);
  }

}
