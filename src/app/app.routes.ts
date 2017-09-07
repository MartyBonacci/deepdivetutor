import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home.component";
import {ProfileComponent} from "./components/profile.component";
import {BrowseComponent} from "./components/browse.component";
import {NavbarComponent} from "./components/navbar.component";
import {SessionService} from "./services/session.service";

export const allAppComponents = [
	HomeComponent,
	ProfileComponent,
	BrowseComponent,
	NavbarComponent
];

export const routes: Routes = [
	{path: "browse", component: BrowseComponent},
	{path: "profile", component: ProfileComponent},
	{path: "", component: HomeComponent}
];

export const appRoutingProviders: any[] = [SessionService];

export const routing = RouterModule.forRoot(routes);