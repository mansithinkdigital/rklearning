# Comprehensive Mobile API Endpoint Catalog

Detailed breakdown of parameters mapped inside `routes/api.php`.

## General Request Headers

Ensure headers are configured globally across models:
```json
{
  "Accept": "application/json",
  "Content-Type": "application/json"
}
```
*(Append `Authorization: Bearer <TOKEN>` for Sanctum protection)*.

---

## 1. Public Endpoints (No Auth Needed)

### Fetch Branches
- **Method**: `GET`
- **URI**: `/api/branches`
- **Input parameters**: None
- **Returned payload**: Array of existing Branch structs.

### Active Course Inventory
- **Method**: `GET`
- **URI**: `/api/courses`
- **Input parameters**: None
- **Returned payload**: Array of active Course structs.

### Dedicated Course Query
- **Method**: `GET`
- **URI**: `/api/courses/{id}`
- **Input parameters**: `id` (Path variable).
- **Returned payload**: Course details with subject relationships.

### Free Videos
- **Method**: `GET`
- **URI**: `/api/free-videos`
- **Input parameters**: None
- **Returned payload**: Array of FreeVideo structs.

### Free PDFs
- **Method**: `GET`
- **URI**: `/api/free-pdfs`
- **Input parameters**: None
- **Returned payload**: Array of Freepdf structs with course relationships.

---

## 2. Authentication Parameters

### Student Registration
- **Method**: `POST`
- **URI**: `/api/student/register`
- **Payload (JSON)**:
  - `name` (String, Required)
  - `mother_name` (String, Required)
  - `email` (String, Email, Required)
  - `phone` (String, Required)
  - `address` (String, Required)
  - `branch_id` (Integer, Required)
  - `password` (String, Required, min:6)

### Standard Login Gateway
- **Method**: `POST`
- **URI**: `/api/student/login`
- **Payload (JSON)**:
  - `email` (String, Required)
  - `password` (String, Required)

---

## 3. Account Adjustments (Protected Student Routes)

### Student Logout
- **Method**: `POST`
- **URI**: `/api/student/logout`
- **Auth required**: Yes
- **Input parameters**: None
- **Returned payload**: Success message.

### View Profile
- **Method**: `GET`
- **URI**: `/api/student/profile`
- **Auth required**: Yes
- **Returned payload**: User profile with branch details.

### Update Profile
- **Method**: `POST`
- **URI**: `/api/student/profile`
- **Auth required**: Yes
- **Payload (JSON)**:
  - `name` (String, Required)
  - `phone` (String, Required)
  - `address` (String, Required)

---

## 4. Student Dashboard & Courses (Protected Student Routes)

### Student Dashboard
- **Method**: `GET`
- **URI**: `/api/student/dashboard`
- **Auth required**: Yes
- **Returned payload**: User details, enrolled courses (approved), and pending requests.

### My Courses
- **Method**: `GET`
- **URI**: `/api/student/my-courses`
- **Auth required**: Yes
- **Returned payload**: Array of enrolled courses (approved).

### Course Details
- **Method**: `GET`
- **URI**: `/api/student/my-courses/{course_id}`
- **Auth required**: Yes
- **Input parameters**: `course_id` (Path variable).
- **Returned payload**: Detailed course structure (subjects, units, topics, paid videos, free pdfs).

### Study Material
- **Method**: `GET`
- **URI**: `/api/student/study-material`
- **Auth required**: Yes
- **Returned payload**: Array of topics with study material for enrolled courses.

---

## 5. Exam Management (Protected Student Routes)

### List Exams
- **Method**: `GET`
- **URI**: `/api/student/exams`
- **Auth required**: Yes
- **Returned payload**: Course subjects with MCQs and previous results if any.

### Start Exam
- **Method**: `GET`
- **URI**: `/api/student/exams/{course_subject_id}/start`
- **Auth required**: Yes
- **Input parameters**: `course_subject_id` (Path variable).
- **Returned payload**: Course subject info and questions (answers hidden).

### Submit Exam
- **Method**: `POST`
- **URI**: `/api/student/exams/{course_subject_id}/submit`
- **Auth required**: Yes
- **Input parameters**: `course_subject_id` (Path variable).
- **Payload (JSON)**:
  - `answers` (Object/Array of question_id => answer)
- **Returned payload**: Exam result (score, status, correct answers count, etc.).
