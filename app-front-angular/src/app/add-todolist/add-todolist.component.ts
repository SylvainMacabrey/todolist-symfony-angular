import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormGroup, FormControl, Validators, NgForm } from '@angular/forms';
import { TodolistService } from '../services/todolist.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-add-todolist',
  templateUrl: './add-todolist.component.html',
  styleUrls: ['./add-todolist.component.css']
})
export class AddTodolistComponent implements OnInit {

  public todolistForm: FormGroup;

  constructor(private fb: FormBuilder, private todolistService: TodolistService, private router: Router) { }

  ngOnInit(): void {
    this.todolistForm = this.fb.group({
      title: ['', Validators.required],
      tasks: this.fb.array([])
    });
  }

  public get tasks(): FormArray {
    return this.todolistForm.get('tasks') as FormArray;
  }

  public addTask(): void {
    this.tasks.push(new FormControl());
  }

  public deleteTask(index: number): void {
    this.tasks.removeAt(index);
    this.tasks.markAsDirty();
  }

  public submitForm(): void {
    this.todolistService.addTodolist(this.todolistForm.value).subscribe(
      response => {
        console.log(response);
        this.router.navigate(['todolist']);
      }
    );
  }

}
