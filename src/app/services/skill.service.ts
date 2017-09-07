import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {Skill} from "../classes/skill";
import {ProfileSkill} from "../classes/profileSkill";
import {BaseService} from "./base.service";

@Injectable()
export class SkillService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private skillUrl = "api/Skill";

	getAllSkillNames(): Observable<Skill[]> {
		return (this.http.get(this.skillUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}
	getSkillNameBySkillId(skillNameSkillId:number): Observable<Skill[]>{
		return (this.http.get(this.skillUrl + "?skillNameSkillId=" + skillNameSkillId)
			.map(this.extractData)
			.catch(this.handleError));
	}
	createProfileSkill(profileSkill:ProfileSkill): Observable<ProfileSkill[]>{
		return (this.http.post(this.skillUrl,profileSkill)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}