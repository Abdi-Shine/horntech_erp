# /redesign

Redesign an existing Blade page or section with improved UI.

## Instructions

The user will point to a page or section to redesign. Follow this process:

1. **Read the current file** thoroughly — understand all the data, forms, and functionality
2. **Read the layout and 2-3 other well-designed pages** for the design system reference
3. **Identify what to improve:**
   - Visual hierarchy (headings, sections, spacing)
   - Color usage and consistency
   - Card/panel layouts
   - Table design (sorting indicators, row actions, status badges)
   - Form layout (grid, labels, input sizing)
   - Empty states and loading states
   - Action buttons (placement, color, icons)
4. **Rewrite the Blade file** with the improved design — keep ALL existing functionality intact
5. **Do not change any PHP logic, routes, or controllers** — only the HTML/Tailwind/Alpine layer
6. **Explain the key design changes** made

## Design Principles to Follow

- Use consistent card containers: `bg-white rounded-lg shadow p-6`
- Page headers: title on left, primary action button on right
- Tables: striped rows, sticky header on long tables, action icons in last column
- Status badges: colored pills using Tailwind `bg-*-100 text-*-800 rounded-full px-2 py-0.5 text-xs`
- Forms: 2-column grid on desktop, single column on mobile
- Keep RTL support if the project uses it (check existing pages)
