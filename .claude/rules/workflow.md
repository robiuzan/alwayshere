# Workflow Rules

## Process

1. Think step-by-step before writing any code.
2. For any task touching > 2 files or > 5 minutes of work:
   - Output a plan: affected files, hook/filter changes, risks, test strategy.
   - Wait for approval before implementing.
3. Write failing tests first (TDD) when adding or changing behavior.
4. After writing or modifying any PHP, JS, or CSS file → run the `code-reviewer` agent before considering the task done.
5. Before proposing a commit: run tests + lint + build. Show output. Only proceed when green.
5. If uncertain (> 5% doubt): ask clarifying questions before writing code.
6. Use Plan Mode for architectural decisions.

## Never Do

- Never invent new naming schemes, file structures, or abstractions without approval.
- Never add logging, telemetry, or debug output unless explicitly asked.
- Never output partial or truncated code blocks.
- Never over-engineer: no abstraction for one-time use, no hypothetical future requirements.
- Never add backwards-compatibility shims — just change the code.

## Commands

```bash
# Local dev (update for your tool: LocalWP / DDEV / Lando)
wp server start

# WP CLI
wp plugin list
wp theme list
wp post list

# Assets (from theme root)
npm run dev          # watch
npm run build        # production build

# Composer (plugin/theme dependencies)
composer install
composer dump-autoload

# PHP lint
composer run lint
./vendor/bin/phpcs --standard=WordPress src/

# Tests
composer run test
./vendor/bin/phpunit
```

## Self-Improvement

- After repeated corrections → suggest adding a new rule to the relevant `.claude/rules/` file.
- After bugs/regressions → root-cause and strengthen the relevant rule.
- After good sessions → ask: *"What new rule should we add based on this session?"*
