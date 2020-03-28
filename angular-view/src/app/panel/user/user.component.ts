import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {AuthenticationService} from "../../services/authentication.service";

@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.less']
})
export class UserComponent implements OnInit {
  profileId;
  currentUser;

  constructor(
      private route: Router,
      private auth: AuthenticationService
  ) {
    if (!this.auth.isAuthenticated()) {
      this.route.navigate(['/login']);
    }
  }

  ngOnInit(): void {
  }

  logout() {
    this.auth.logout();
    this.route.navigate(['']);
  }
}
