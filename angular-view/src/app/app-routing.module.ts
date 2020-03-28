import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {HomeComponent} from './home/home.component';
import {UserComponent} from "./panel/user/user.component";
import {AdminComponent} from "./panel/admin/admin.component";


const routes: Routes = [
  {
    path: 'panel/admin',
    component: AdminComponent,
  },
  {
    path: 'panel/:id',
    component: UserComponent,
  },
  {
    path: '',
    component: HomeComponent,
  },
  {
    path: 'login',
    component: HomeComponent,
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
