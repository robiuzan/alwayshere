---
description: Create a new Claude Code skill (custom slash command) for this project
---

Create a new skill based on: $ARGUMENTS

A skill is a custom slash command saved as a `.md` file in `.claude/commands/`.

Follow these steps:

1. **Clarify the skill** (if $ARGUMENTS is vague, ask):
   - What should `/skill-name` do?
   - Does it need user input (`$ARGUMENTS`)?
   - Is it a one-shot action or a multi-step workflow?

2. **Choose a filename** — short, lowercase, hyphenated (e.g., `fix-rtl.md`, `new-product.md`)

3. **Write the skill file** at `.claude/commands/<name>.md` with this structure:

```markdown
---
description: One-line description shown in /help
---

Clear instructions for what Claude should do when this skill is invoked.

Reference $ARGUMENTS where the user's input should be used.

Break into numbered steps if it's a multi-step workflow.
Be explicit — write it as if explaining to a smart assistant who knows the project
but needs precise instructions for this specific task.
```

4. **Confirm** by showing:
   - The file path created
   - How to invoke it: `/skill-name [optional args]`
   - A one-line example usage

Rules for good skills:
- Be specific — vague instructions produce vague results
- Reference project context (alwayshere.co.il, Hebrew, WooCommerce, Yoast) where relevant
- Keep it focused — one skill, one job
- Use $ARGUMENTS for anything the user should provide at invocation time
