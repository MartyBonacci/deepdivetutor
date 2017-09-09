import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home.component";
import {ProfileComponent} from "./components/profile.component";
import {BrowseComponent} from "./components/browse.component";
import {NavbarComponent} from "./components/navbar.component";
import {SessionService} from "./services/session.service";
import {FooterComponent} from "./components/footer.component";
import {ReviewComponent} from "./components/review.component";
import {SignInComponent} from "./components/sign-in.component";
import {SignInService} from "./services/sign-in.service";


export const allAppComponents = [
	HomeComponent,
	ProfileComponent,
	BrowseComponent,
	NavbarComponent,
	FooterComponent,
	ReviewComponent,
	SignInComponent
];

export const routes: Routes = [
	{path: "browse", component: BrowseComponent},
	{path: "profile", component: ProfileComponent},
	{path: "", component: HomeComponent}
];

export const appRoutingProviders: any[] = [SessionService, SignInService];

export const routing = RouterModule.forRoot(routes);