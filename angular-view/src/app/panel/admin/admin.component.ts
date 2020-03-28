import { Component, OnInit } from '@angular/core';
import {UserService} from '../../services/user.service';
import {UserInterface} from '../../interfaces/user'

@Component({
  selector: 'app-admin',
  templateUrl: './admin.component.html',
  styleUrls: ['./admin.component.less'],
  providers: [UserService]
})
export class AdminComponent implements OnInit {
  users: UserInterface;

  constructor(private userService: UserService) {
  }
  showUsers() {
    this.userService.getUsers().subscribe(data => {
        this.users = data;
        console.log(this.users);
    });
  }
  showUsersFull() {
    this.userService.getUsers().subscribe(
        data => {
            this.users = data;
        });
  }
  ngOnInit(): void {
    this.showUsers();
  }
}
