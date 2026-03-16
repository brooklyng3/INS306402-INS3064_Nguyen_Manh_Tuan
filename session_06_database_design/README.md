## **Part 1: Normalization**

### Task 1 — Identify violations

> Which columns lead to redundancy?

A: Column `StudentName`, `CourseName`, `ProfessorName` and `ProfessorEmail` lead to redundancy

> Where could update anomalies happen (email change, course rename)?

A: Email change, course name, student name, 

>  Is there any transitive dependency?

A: Yes. CourseID → ProfessorName → ProfessorEmail

### Task 2 — Decompose to 3NF

#### Decomposition to 2NF (Remove Partial Dependencies)

**Partial dependencies identified**:

- StudentName depends only on StudentID (not on the full key).
- CourseName, ProfessorName, ProfessorEmail depend only on CourseID (not on the full key).
- Only Grade depends on the full composite key.

**2NF Tables** (lossless decomposition):

1. **Students**
    - StudentID **(PK)**
    - StudentName
2. **Courses** (temporary name)
    - CourseID **(PK)**
    - CourseName
    - ProfessorName
    - ProfessorEmail
3. **Enrollments** 
    - StudentID **(FK → Students)**
    - CourseID **(FK → Courses)**
    - Grade 
    - PK (StudentID, CourseID)

Table Enrollments exists because (Student-Course is N-N relationship)

#### Decomposition to 3NF

Transitive dependency found: CourseID → ProfessorName → ProfessorEmail

Target Tables:
#### 1. **Students**

- **PK**: StudentID
- StudentName
- **Constraints**: StudentID UNIQUE + NOT NULL

#### 2. **Professors**

- **PK**: ProfessorName
- ProfessorEmail
- **Constraints**: ProfessorName UNIQUE + NOT NULL; ProfessorEmail UNIQUE 

#### 3. **Courses**

- **PK**: CourseID
- CourseName
- ProfessorName **(FK → Professors.ProfessorName)**
- **Constraints**: CourseID UNIQUE + NOT NULL; ProfessorName NOT NULL 

#### 4. **Enrollments**

- **PK**: (StudentID, CourseID)
- StudentID **(FK → Students.StudentID)**
- CourseID **(FK → Courses.CourseID)**
- Grade
- **Constraints**: Both FKs ON DELETE CASCADE / RESTRICT


### Why Each Table Exists

- **Students** Exists because student information is independent of courses/grades. → Eliminates partial dependency on StudentID. 
- **Professors** Exists to isolate professor data (especially the transitive dependency). 
- **Courses** Exists because course details + assigned professor belong together.
- **Enrollments** Exists as the junction table for the many-to-many relationship (Student ↔ Course) with the grade attribute.

| Table       | Primary Key             | Foreign Key(s)                                                       | Non-key columns  |
| ----------- | ----------------------- | -------------------------------------------------------------------- | ---------------- |
| Students    | `StudentID`             | None                                                                 | `StudentName`    |
| Courses     | `CourseID`              | `ProfessorName` → `Professors(ProfessorName)`                        | `CourseName`     |
| Professors  | `ProfessorName`         | None                                                                 | `ProfessorEmail` |
| Enrollments | `(StudentID, CourseID)` | `StudentID` → `Students(StudentID)` `CourseID` → `Courses(CourseID)` | `Grade`          |
## Part 2: Relationship Drills

- **Authors to Books:** Many-to-Many (N:N). An author can write many books, and a book can have multiple authors.
- **Citizens to Passports:** One-to-Many (1:N). A single citizen can hold multiple passports (due to dual citizenship), but one specific physical passport belongs to exactly one citizen. 
- **Customers to Orders:** One-to-Many (1:N). A single customer can place multiple orders over time, but one specific order is placed by exactly one customer.
- **Students to Classes:** Many-to-Many (N:N). A single student can enroll in multiple classes, and a single class can have multiple students enrolled.
- **Teams to Players:** One-to-Many (1:N). A single team consists of many players, but a specific player typically plays for exactly one team at a given time.