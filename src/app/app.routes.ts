import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home.component";
import {ProfileComponent} from "./components/profile.component";
import {SessionService} from "./services/session.service";
import {SkillService} from "./services/skill.service";


export const allAppComponents = [HomeComponent, ProfileComponent];

export const routes: Routes = [
	{path: "profile", component: ProfileComponent},
	{path: "", component: HomeComponent}
];

export const appRoutingProviders: any[] = [SessionService];
export const appRoutingProviders: any[] = [SkillService];

export const routing = RouterModule.forRoot(routes);