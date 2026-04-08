# /ui-review

Review a Blade view or UI section for design quality, consistency, and best practices.

## Instructions

The user will provide a file path or page name to review. Perform a thorough UI/UX review:

1. **Read the target file** and 2-3 related pages for context
2. **Check design consistency** — spacing, colors, typography match the rest of the app
3. **Check Tailwind usage** — no hardcoded inline styles, uses utility classes correctly
4. **Check Alpine.js** — reactive data is clean, no unnecessary complexity
5. **Check responsiveness** — mobile-friendly layout, proper breakpoints
6. **Check accessibility** — labels on inputs, contrast, ARIA where needed
7. **Check form UX** — validation errors shown clearly, loading states, disabled states
8. **Check table/list design** — headers, row hover, empty states, pagination

## Output Format

Provide feedback as:
- **Critical** — broken, inconsistent, or confusing
- **Improvements** — could be better
- **Good** — what's working well

Then offer to apply the fixes.
