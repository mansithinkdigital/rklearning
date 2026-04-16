### 🎯 Objective

Redesign the **Courses Management (Admin Panel)** to support a structured hierarchy:

**Course → Subjects → Units → Topics**

---

### 🧱 Data Structure

Define the following entities:

1. **Course**

   * id
   * title
   * description
   * thumbnail (optional)
   * status (draft/published)

2. **Subject**

   * id
   * course_id (FK)
   * name
   * description (optional)
   * order (for sorting)

3. **Unit**

   * id
   * subject_id (FK)
   * name
   * order

4. **Topic**

   * id
   * unit_id (FK)
   * title
   * content (text/video/file)
   * duration (optional)
   * order

---

### 🔁 Relationships

* One Course → Many Subjects
* One Subject → Many Units
* One Unit → Many Topics

---

### 🖥️ Admin Flow (UI/UX)

#### 1. Courses List Page

* Show all courses in card/table view
* Button: **"Add Course"**
* Each course has:

  * Edit
  * Delete
  * "Manage Content" (important)

---

#### 2. Add/Edit Course Page

* Fields:

  * Title
  * Description
  * Thumbnail upload
  * Status toggle
* Save → redirect to "Manage Content"

---

#### 3. Manage Content Page (Core Feature)

Split UI into sections:

##### LEFT PANEL (Hierarchy Tree)

* Course

  * Subjects

    * Units

      * Topics

👉 Expand/collapse tree structure

---

##### RIGHT PANEL (Dynamic Editor)

Based on selection:

* If Subject selected → show subject form
* If Unit selected → show unit form
* If Topic selected → show topic form

---

### ➕ Add Actions

At each level:

* Add Subject (under course)
* Add Unit (under subject)
* Add Topic (under unit)

Use buttons like:

* "+ Add Subject"
* "+ Add Unit"
* "+ Add Topic"

---

### 🔀 Ordering

* Enable drag-and-drop OR manual ordering field
* Maintain `order` column in DB

---

### 💾 Save Behavior

* Auto-save OR explicit "Save Changes" button
* Use APIs:

  * POST /courses
  * POST /subjects
  * POST /units
  * POST /topics
  * PUT /update endpoints
  * DELETE endpoints

---

### 🎨 UI Suggestions

* Use collapsible tree (like file explorer)
* Highlight selected item
* Use breadcrumbs:
  Course > Subject > Unit > Topic

---

### ⚙️ Optional Enhancements

* Bulk upload topics (CSV)
* Rich text editor for topic content
* Video upload / embed support
* Preview mode for course

---

### 🚫 Constraints

* Do NOT allow creating Unit without Subject
* Do NOT allow creating Topic without Unit
* Validate required fields at each level

---

### ✅ Expected Outcome

Admin can:

1. Create multiple courses
2. Enter a course
3. Add subjects inside it
4. Add units inside subjects
5. Add topics inside units
6. Easily navigate and edit via clean UI
