import {Component, ViewChild,OnInit} from "@angular/core";
import {Observable} from "rxjs/Observable"
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import {SkillService} from "../services/skill.service";
import {ProfileService} from "../services/profile.service";
import {Profile} from "../classes/profile";
import {CookieService} from "ng2-cookies";
import {Skill} from "../classes/skill";

//declare $ for good old jquery
declare let $: any;

@Component({
	templateUrl: "./templates/profile-edit.html",
	selector: "profile-edit"
})

export class ProfileEditComponent implements OnInit {
	profile: Profile= new Profile(null,null,null,null,null,null,null,null,null);
	status: Status = null;
	cookieJar : any = {};
	skills: Skill[] = [];
	constructor(private profileService: ProfileService, private router: Router, private skillService: SkillService, private cookieService: CookieService) {
	}

	ngOnInit(): void {
		this.reloadProfiles();
	}

	reloadProfiles(): void {
		this.cookieJar = this.cookieService.getAll();
		this.profileService.getProfileByProfileId(this.cookieJar['profileId'])
			.subscribe (profile=>this.profile=profile);
	}

	getAllSkillNames(): void{
		this.skillService.getAllSkillNames()
			.subscribe (skills=>this.skills=skills);
	}

}
