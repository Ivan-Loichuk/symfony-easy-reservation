import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { PanelHeaderComponent } from './panel-header/panel-header.component';
import { PanelFooterComponent } from './panel-footer/panel-footer.component';
import {HomeComponent} from './home/home.component';
import {HttpClientModule} from '@angular/common/http';
import { LoginComponent } from './security/login/login.component';
import { RegistrationComponent } from './security/registration/registration.component';
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import { AdminComponent } from './panel/admin/admin.component';
import { UserComponent } from './panel/user/user.component';

@NgModule({
  declarations: [
    AppComponent,
    PanelHeaderComponent,
    PanelFooterComponent,
    HomeComponent,
    LoginComponent,
    RegistrationComponent,
    AdminComponent,
    UserComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    FormsModule,
    ReactiveFormsModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
