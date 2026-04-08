# /new-page

Scaffold a new Blade view page for the Bilkheyr admin panel.

## Instructions

The user will provide a page name and module. Create a complete, styled Blade page that:

1. **Extends the correct layout** — use `@extends('layouts.app')` or the admin layout used by similar pages
2. **Includes proper `@section` blocks** — title, breadcrumb, content
3. **Uses Tailwind CSS** — consistent with the rest of the project (spacing, colors, card styles, typography)
4. **Adds Alpine.js interactivity** where needed (dropdowns, modals, toggles)
5. **Matches existing design patterns** — read 2-3 similar existing pages first to match style exactly
6. **Adds the route** in `routes/web.php` with appropriate middleware (auth, permission)
7. **Adds the controller method** if it doesn't exist

## Steps

1. Ask the user: page name, which module it belongs to, and what content it should show
2. Read 2 similar existing pages to understand the design system
3. Read the relevant layout file
4. Create the Blade view
5. Add the route
6. Add or update the controller method
7. Show the user what was created
