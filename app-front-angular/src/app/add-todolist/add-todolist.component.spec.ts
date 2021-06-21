import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AddTodolistComponent } from './add-todolist.component';

describe('AddTodolistComponent', () => {
  let component: AddTodolistComponent;
  let fixture: ComponentFixture<AddTodolistComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AddTodolistComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AddTodolistComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
