# Jungle Statamic Project — Developer Boilerplate

This file documents the conventions, patterns, and architecture used across all Jungle Statamic projects. Paste the contents of this file at the start of any new Claude session to maintain consistency.

---

## STACK

- Statamic 4 with Antlers templating
- Tailwind CSS 3.4 (arbitrary values, opacity modifiers, group-has variants)
- Alpine.js for all interactivity (x-data, x-show, x-transition, @events, :class bindings)
- Swiper.js for carousels
- Font Awesome (fa-sharp fa-regular / fa-solid / fa-light) for all icons
- Glide (Statamic image transform tag) for all image resizing
- Vite for asset bundling

---

## FILE STRUCTURE

```
resources/
  views/
    layout.antlers.html          ← root HTML shell (<html>, <head>, <body>)
    default.antlers.html         ← renders page_builder for standard pages
    layout/
      _header.antlers.html       ← fixed header, includes desktop + mobile partials
      _header-desktop.antlers.html
      _header-mobile.antlers.html
      _header-mobile-slideover.antlers.html
      _footer.antlers.html
    page_builder/
      _[set_name].antlers.html   ← one file per page builder set, prefixed _
    components/
      _button.antlers.html
      _form_builder.antlers.html
      _form_submit.antlers.html
      above-title.antlers.html
      icons/                     ← SVG icon partials
    partials/
      _hero.antlers.html         ← reusable hero (called from page_builder/_hero.antlers.html)
      related-blogs.antlers.html
      related-case-studies.antlers.html
    vendor/statamic/forms/fields/
      text.antlers.html          ← all form field types rendered here
      textarea.antlers.html
      select.antlers.html
      checkboxes.antlers.html
      radio.antlers.html

  fieldsets/
    page_builder.yaml            ← the master replicator definition
    [name].yaml                  ← reusable field groups referenced from page_builder.yaml

  blueprints/
    collections/
      pages.yaml
      blog.yaml
      services.yaml
      sectors.yaml
      case_studies.yaml
    globals/
      brand.yaml
      header.yaml
      footer.yaml
    forms/
      [form_handle].yaml         ← form field definitions

  forms/
    [form_handle].yaml           ← form config (title, honeypot, store: true)

content/
  globals/
    brand.yaml
    header.yaml
    footer.yaml
```

---

## GLOBALS

### brand global (handle: brand)
Fields: logo (assets), email, number, address, office_hours, primary_color, brand_secondary, brand_red, black, white, grey.

```antlers
{{ brand:email }}
{{ brand:number }}
{{ brand:address }}
{{ brand:office_hours }}
{{ brand:logo }}<img src="{{ url }}" alt="{{ alt }}">{{ /brand:logo }}
```

### header global (handle: header)
Fields: cta_link (link fieldtype), cta_title (text).

```antlers
{{ header:cta_link }}{{ link:url }}{{ /header:cta_link }}
{{ header:cta_title }}
```

### footer global (handle: footer)
Accessed as `{{ footer:[field] }}` or via the footer page builder set.

---

## TAILWIND CONVENTIONS

- **Font sizes**: always use arbitrary values → `text-[14px]`, `text-[16px]`, `text-[22px]`. Never use `text-sm`, `text-base`, `text-lg` etc.
- **Colours**: `text-black`, `text-white`, `text-brand-primary`, `text-brand-secondary`. Opacity via modifier: `text-black/60`, `bg-black/10`, `border-white/20`.
- **Group hover**: `group` on parent, `group-hover:` on child. e.g. `group-hover:blur-sm`, `group-hover:scale-105`.
- **group-has-[:checked]**: for custom radio/checkbox state (Tailwind 3.4+). Put `group` on `<label>`, use `group-has-[:checked]:` on sibling spans.
- **Alpine :class bindings** for state-driven styles (not group-hover CSS): `:class="condition ? 'bg-black/50' : 'bg-black/10'"`
- **Transitions**: `transition-[property] duration-300 ease-in-out`. For Alpine: x-transition with enter/leave + start/end.

---

## SECTION & LAYOUT PATTERN

Every page builder section uses this structure:

```html
<section class="section">
    <div class="container">
        <!-- content -->
    </div>
</section>
```

- `.section` = 80px/100px/140px vertical padding (defined in site.css).
- `.container` = max-width 1364px, auto margins, horizontal padding (defined in site.css).
- Override padding with Tailwind when needed: `!pt-0`, `!pt-[190px]`.
- Dark sections use `bg-black` or `bg-brand-secondary` directly on `<section>`.

### Above-title pattern (used on most sections):

```antlers
{{ partial:components/above-title title="Section Label" }}
<hr class="section__hr js-fade-up">
```

`above-title` renders a small uppercase label with a brand-primary arrow icon. `section__hr` is a thin decorative rule.

### Scroll animation:
Add `js-fade-up` class to elements that should animate in on scroll. Handled by `site.js`.

---

## PAGE BUILDER SYSTEM

### How it works:
1. `resources/fieldsets/page_builder.yaml` defines a replicator field with sets.
2. Each set maps to a partial: `resources/views/page_builder/_{set_type}.antlers.html`
3. `resources/views/default.antlers.html` loops through sets:

```antlers
{{ page_builder }}
{{ partial src="page_builder/{type}" }}
{{ /page_builder }}
```

### Adding a new page builder element:
1. Add the set definition to `resources/fieldsets/page_builder.yaml` under `sets > new_set_group > sets`.
2. Create the partial at `resources/views/page_builder/_{set_name}.antlers.html`.
3. The partial has direct access to all fields defined in the set (no extra scoping needed).

### Reusable field groups (fieldsets):
Complex field groups are defined in `resources/fieldsets/[name].yaml` and referenced from `page_builder.yaml` using `field: [fieldset].[handle]` syntax.

---

## BUTTON COMPONENT

```antlers
{{ partial:components/button url="..." title="..." target="..." classes="..." }}
```

- Renders an `<a>` with `class="button group {{ classes }}"` plus an animated double-arrow icon.
- **First CTA** on any section: `classes=""` (solid/filled style).
- **Second CTA** on any section: `classes="button__outline"` (outline style).
- For external links: `target="_blank"`.

### CTA fields from the ctas fieldset:
```antlers
{{ ctas }}
{{ if type == "cta" }}
{{ btn_classes = "button__outline" }}
{{ if index == 1 }}{{ btn_classes = "" }}{{ /if }}
{{ partial:components/button url="{ cta__link:url }" title="{ cta_title }" target="{ cta__link:target }" classes="{ btn_classes }" }}
{{ /if }}
{{ /ctas }}
```

---

## CAROUSEL PATTERN (Swiper.js)

Navigation buttons always use fa-sharp arrow icons:
- Previous: `fa-sharp fa-regular fa-arrow-down-left`
- Next: `fa-sharp fa-regular fa-arrow-up-right`

On dark backgrounds (`bg-black`): `border-white`, `text-white` buttons.
On light backgrounds: `border-black`, `text-black` buttons.

```html
<button class="swiper-prev w-10 h-10 rounded-full border border-white flex items-center justify-center">
    <i class="fa-sharp fa-regular fa-arrow-down-left text-white text-[12px]"></i>
</button>
```

---

## COLLECTION CARD HOVER PATTERN

All collection entry cards (blogs, case studies, services, sectors) use this image hover effect:
- Add `group` to the `<a>` wrapper.
- On the `<img>`: `group-hover:blur-sm group-hover:scale-105 transition-all duration-500`.
- Arrow icon that fades/rises in on hover:

```html
<i class="fa-sharp fa-regular fa-circle-arrow-up-right text-white opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-300 text-[24px]"></i>
```

### Image fallback pattern (Glide tags cannot use ?? operator):
```antlers
{{ if card_image }}
<img src="{{ glide:card_image width='800' height='600' fit='crop' }}" alt="{{ title }}">
{{ elseif hero_image }}
<img src="{{ glide:hero_image width='800' height='600' fit='crop' }}" alt="{{ title }}">
{{ /if }}
```

---

## COLLECTIONS

| Handle | Template | Notes |
|---|---|---|
| pages | default.antlers.html | Standard pages using page builder |
| services | services.antlers.html | Individual service pages |
| sectors | sectors.antlers.html | Individual sector pages |
| blog | blog_post.antlers.html | Taxonomy: blog_category |
| case_studies | case_study.antlers.html | Taxonomy: category |

Common entry fields: `title`, `hero_image` (assets), `card_image` (assets), `card_text` (textarea), `slug`.

### Querying collections:
```antlers
{{ collection:blog sort="date:desc" limit="3" }}...{{ /collection:blog }}
{{ collection:blog sort="random" limit="3" :id:not="exclude" }}...{{ /collection:blog }}
```

### Taxonomy output:
```antlers
{{ blog_category }}{{ if first }}{{ title }}{{ /if }}{{ /blog_category }}
```

---

## NAVIGATION

Single nav: `main_menu` (configured in Statamic CP > Navigation).

```antlers
{{ nav:main_menu }}
    {{ id }}, {{ title }}, {{ url }}, {{ children }}, {{ count }}
    {{ children }}
        {{ title }}, {{ url }}, {{ count }}, {{ card_image }}, {{ hero_image }}, {{ card_text }}
    {{ /children }}
{{ /nav:main_menu }}
```

### Desktop mega menu pattern:
- Outer wrapper: `x-data="{ scrolled: false, open: null }"` with scroll listener.
- Nav loop runs **twice**: once for the link row (`@mouseenter="open = '{{ id }}'"`), once for dropdown panels (`x-show="open === '{{ id }}'""`).
- Both loops are siblings inside a `.relative` wrapper with `@mouseleave="open = null"`.
- Each dropdown: `x-data="{ active: 1 }"` — children panels expand with `flex-[4]`/`flex-[1]` driven by `:class="active === {{ count }} ? 'flex-[4]' : 'flex-[1]'"`.
- Overlay colour is Alpine-driven: `:class="active === {{ count }} ? 'bg-black/50' : 'bg-black/10'"` (do NOT use group-hover CSS for this).
- Expanded content elements (title, arrow, card_text) are each **separate direct absolute children** of the `<a>` with their own `x-show` and `x-transition`.

### Mobile slideover:
- Separate partial: `layout/_header-mobile-slideover.antlers.html`
- `fixed inset-0 bg-black z-[100] overflow-y-auto`, slides from right: `x-transition:enter-start="translate-x-full"`
- Large parent nav links (32–36px bold white), children in `text-white/80` listed below.
- Bottom panel: brand globals (email, phone, address) + CTA button.
- All links: `@click="open = false"` to close on navigate.

---

## FORM SYSTEM

### Creating a form:

**1. `resources/forms/[handle].yaml`** — form config:
```yaml
title: Form Title
honeypot: honeypot
store: true
```

**2. `resources/blueprints/forms/[handle].yaml`** — field definitions.

> **CRITICAL**: There is no `type: email` fieldtype in Statamic. Use `type: text` with `input_type: email`.

Set `width: 50` (or 25/33/66/75/100) on each field for column layout. Add `placeholder: [text]` in sentence case (not uppercase).

### Field types: `text`, `textarea`, `select`, `radio`, `checkboxes`.
- `checkboxes`: for multi-select (user picks multiple options).
- `radio`: for single select only.

### Form field rendering:
Statamic resolves `{{ field }}` via `resources/views/vendor/statamic/forms/fields/{type}.antlers.html`.

> Files in `components/form_builder/` are **not** called by `{{ field }}`. Always create/edit the vendor override files.

### Correct Antlers variables inside vendor field views:

| Variable | Usage |
|---|---|
| `{{ name }}` | field name attribute |
| `{{ id }}` | field id attribute |
| `{{ value }}` | current/submitted value |
| `{{ placeholder }}` | placeholder text from blueprint |
| `{{ display }}` | field label from blueprint |
| `{{ input_type }}` | for text fields (text, email, tel, etc.) |
| `{{ error }}` | validation error message |
| `{{ foreach:options as="option|label" }}` | loop for select/radio/checkboxes |
| `{{ if value \| in_array:option }}checked{{ /if }}` | for checkboxes |
| `{{ if option == value }}selected{{ /if }}` | for select |

### Form field styles:
- **text/email/tel**: `border-b border-black/20`, `bg-transparent`, `py-4`, `placeholder-black/40`
- **textarea**: `bg-transparent`, `py-2`, `resize-none`
- **select**: `bg-transparent`, `appearance-none`, custom chevron `fa-sharp fa-regular fa-chevron-down`
- **radio/checkboxes**: `sr-only` real input, custom circular indicator using `group-has-[:checked]` on `<label>`

### Using the form builder component:
```antlers
{{ partial:components/form_builder form_handle="[handle]" success_redirect="/thank-you" }}
```

For a selectable form in a page builder set, use `type: form` in the fieldset YAML. In the partial:
```antlers
{{ partial:components/form_builder :form_handle="form_handle:handle" success_redirect="/thank-you" }}
```

The `:` prefix makes the parameter dynamic (reads from a variable).

---

## IMAGE TRANSFORMS (Glide)

```antlers
{{ glide:field_handle width='900' height='500' fit='crop' }}
```

- Always use `fit='crop'` for cards and fixed-ratio images.
- Never use the `??` operator with `glide:` tags — use `if`/`elseif` blocks instead.
- `card_image` is the primary card image; `hero_image` is the fallback.

---

## BARD CONTENT

Wrap bard output in `.bard` for typography styles:

```html
<div class="bard">{{ text }}</div>
```

---

## ALPINE.JS PATTERNS

- All interactivity is Alpine. No vanilla JS event listeners in templates.
- `x-cloak` on elements that should be hidden until Alpine initialises (prevents flash).
- `x-data` on the outermost element that owns the state.
- `x-init` for setup logic (scroll listeners, resize listeners).
- `x-show` with `x-transition` for reveal animations.

```html
x-transition:enter="transition ease-out duration-200"
x-transition:enter-start="opacity-0"
x-transition:enter-end="opacity-100"
```

- `:class` for conditional classes — prefer this over `group-hover` when state is Alpine-driven.

---

## ICON CONVENTIONS

All icons use Font Awesome Sharp Regular by default:

```html
<i class="fa-sharp fa-regular fa-[icon-name] text-[14px]"></i>
```

Switch to `fa-solid` or `fa-light` only when the design specifically requires it. Size icons with `text-[Npx]` arbitrary values.

---

## THINGS TO NEVER DO

- Never use `type: email` as a Statamic fieldtype — it does not exist. Use `type: text` + `input_type: email`.
- Never use the `??` operator inside a `glide:` tag.
- Never use `text-sm`, `text-base`, `text-lg` etc — always use `text-[Npx]`.
- Never put dropdown/mega menu content inside a `<ul>` — it must sit outside to span full width.
- Never use `group-hover` CSS for Alpine state-driven styles — use `:class` bindings.
- Never create form field styles in `components/form_builder/` and expect them to be called by `{{ field }}` — Statamic resolves via `vendor/statamic/forms/fields/{type}.antlers.html`.
- Never nest multiple `x-show` elements inside a single wrapper div when they need independent absolute positioning — each must be a direct absolute child with its own `x-show`.
