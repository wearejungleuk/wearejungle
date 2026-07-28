---
id: 266e758e-6ddb-4eb4-86b8-896b462454e0
blueprint: work
title: 'City of Subculture'
meta_title: 'City of Subculture - Community Platform Build | Jungle'
meta_description: "A free community platform for Portsmouth's grassroots venues, artists and promoters, built by We Are Jungle ahead of the 2029 City of Culture bid."
preview_text:
  -
    type: paragraph
    content:
      -
        type: text
        text: "A free directory and events platform for Portsmouth's grassroots venues, artists and promoters, built by We Are Jungle ahead of the 2029 City of Culture bid."
author: 58fc95e0-3fe5-49b8-aa57-e8aa20e69afa
use_meta_keywords: false
no_index_page: false
no_follow_links: false
sitemap_priority: '0.5'
sitemap_changefreq: monthly
override_twitter_settings: false
hero_background_colour: brand-primary
work_type:
  - web-design
  - web-development
  - hosting
website_url: 'https://cityofsubculture.co.uk'
overview_heading: "A community platform for Portsmouth's independent scene."
overview_body:
  -
    type: paragraph
    content:
      -
        type: text
        text: "City of Subculture is a free platform we've built for the grassroots side of Portsmouth. Venues, artists, food spots, festivals, promoters, community projects. Anyone putting on something worth putting on. No chains. No brands that don't belong to the community. No corporates."
  -
    type: paragraph
    content:
      -
        type: text
        text: "The city is bidding to be UK City of Culture 2029, and the culture that will make or break that bid is scattered across Instagram accounts, Facebook events, printed flyers and word of mouth. City of Subculture pulls it all into one home. It's free for venues to list, free for visitors to browse, and there is no plan to change that."
  -
    type: paragraph
    content:
      -
        type: text
        text: 'This one is on us. It sits alongside the emotional case for the city we wrote up in '
      -
        type: text
        marks:
          -
            type: link
            attrs:
              href: /blog/made-in-pompey-city-of-culture
              rel: null
              target: null
              title: null
        text: 'Made in Pompey'
      -
        type: text
        text: '.'
what_we_did_heading: "A custom directory and events platform, purpose-built for the city."
what_we_did_body:
  -
    type: paragraph
    content:
      -
        type: text
        text: 'The site is built on '
      -
        type: text
        marks:
          -
            type: link
            attrs:
              href: /services/statamic-websites
              rel: null
              target: null
              title: null
        text: Statamic
      -
        type: text
        text: " for the content-managed side (home, blog, site chrome) and Laravel with Filament 4 for the domain layer (venues, events, tenant claims, moderation reports). Two tools, each doing what they're best at, on one codebase."
  -
    type: paragraph
    content:
      -
        type: text
        text: "Every venue gets a profile page with photos, opening hours, categories and a map. The main directory has search by name, filter by category and a postcode field that returns what's near you. Events live in a single citywide feed with the same postcode filtering. Owners create a free account, submit a listing that goes through moderation once, then edit their own profile and add events whenever they want."
  -
    type: paragraph
    content:
      -
        type: text
        text: "Bot protection is Cloudflare Turnstile on every signup, listing submission and tenant claim. Reports of dodgy content route to an internal moderation queue. Images are on DigitalOcean Spaces, email through Postmark, MySQL on DigitalOcean, Cloudflare in front of the whole thing."
what_we_did_features_heading: 'Key Features:'
what_we_did_features:
  -
    id: cos_wwd1
    label: 'Searchable Venue Directory'
    description: 'Every independent venue and business gets a profile page with photos, opening hours, categories, map and postcode-based search.'
    type: new_set
    enabled: true
  -
    id: cos_wwd2
    label: 'City-Wide Events Feed'
    description: 'A single events listing with postcode filtering, per-event detail pages and a direct link back to the venue running it.'
    type: new_set
    enabled: true
  -
    id: cos_wwd3
    label: 'Owner Dashboards'
    description: 'Venue owners register, submit a listing for one-off moderation, then self-serve their profile, hours, photos and events from a dashboard.'
    type: new_set
    enabled: true
  -
    id: cos_wwd4
    label: 'Tenant Claim Flow'
    description: "Owners can claim a listing that already exists on the platform in a couple of clicks, with rate limiting to keep the claim queue clean."
    type: new_set
    enabled: true
  -
    id: cos_wwd5
    label: 'Moderation and Bot Protection'
    description: 'Content reports drop into a Filament moderation queue. Cloudflare Turnstile plus rate limiting guards every signup, submission and claim.'
    type: new_set
    enabled: true
result_heading: 'A city-scale platform, ready to launch and free to use.'
result_body:
  -
    type: paragraph
    content:
      -
        type: text
        text: "Phase 1 is a directory and events platform that puts Portsmouth's independent scene in one place. Any venue in the city can register, claim or list themselves inside a couple of minutes. Every event runs through a single feed, unmoderated by an algorithm."
  -
    type: paragraph
    content:
      -
        type: text
        text: "Phase 2 is native ticketing via Stripe Connect Express with zero platform fee from us. The venue pays Stripe's standard card processing fee and keeps every other penny. The independents we spoke to were handing meaningful chunks of gross ticket revenue to third-party platforms, and that model doesn't work for small rooms. Ticketing ships as a follow-up to launch."
result_cards:
  -
    id: cos_rc1
    fa_icon: shop
    statement: 'A free directory of every grassroots venue in the city, searchable and filterable by postcode.'
    type: new_set
    enabled: true
  -
    id: cos_rc2
    fa_icon: calendar-days
    statement: 'A citywide events feed with no algorithm deciding what people get to see.'
    type: new_set
    enabled: true
  -
    id: cos_rc3
    fa_icon: user-gear
    statement: 'Owner dashboards so venues self-serve their listing, hours, photos and events.'
    type: new_set
    enabled: true
  -
    id: cos_rc4
    fa_icon: ticket
    statement: 'Native ticketing on Stripe Connect coming in phase 2 with zero platform fee.'
    type: new_set
    enabled: true
feature_list:
  -
    id: cos_fl1
    fa_icon: shop
    label: 'Searchable Venue Directory'
    description: 'Every independent venue in the city gets a profile page with photos, hours, categories, map and postcode search.'
    type: new_set
    enabled: true
  -
    id: cos_fl2
    fa_icon: calendar-days
    label: 'City-Wide Events Feed'
    description: 'One unified events listing with postcode filtering, event detail pages and a direct link back to the host venue.'
    type: new_set
    enabled: true
  -
    id: cos_fl3
    fa_icon: user-gear
    label: 'Owner Dashboards'
    description: 'Free accounts for venue owners with self-serve listing management and owner-created events.'
    type: new_set
    enabled: true
  -
    id: cos_fl4
    fa_icon: hand-holding-heart
    label: 'Tenant Claim Flow'
    description: 'Claim an existing listing in a couple of clicks, with throttling to protect the queue from abuse.'
    type: new_set
    enabled: true
  -
    id: cos_fl5
    fa_icon: shield-halved
    label: 'Moderation and Bot Protection'
    description: 'Cloudflare Turnstile plus rate limiting on every signup, submission and claim, with an internal content-report queue.'
    type: new_set
    enabled: true
  -
    id: cos_fl6
    fa_icon: ticket
    label: 'Phase 2: Native Ticketing'
    description: 'Stripe Connect Express ticketing coming as phase 2, with zero platform fee from We Are Jungle.'
    type: new_set
    enabled: true
show_before_after: false
intro_card_text: "A free directory and events platform for Portsmouth's grassroots, built by us ahead of the 2029 City of Culture bid."
card_text_2:
  -
    type: paragraph
    content:
      -
        type: text
        text: "A free community platform for the venues, artists and promoters keeping this city interesting. Phase 1 directory and events at launch, native Stripe Connect ticketing to follow in phase 2."
page_builder:
  -
    id: work_cta_cos
    above_title: 'Building something for your community?'
    above_title_variant: above-title--light-blue
    title: 'Got a Platform Idea That Needs a Proper Build?'
    text:
      -
        type: paragraph
        content:
          -
            type: text
            text: 'If you have a community, directory or events platform in mind and want it built to scale, run cleanly and belong to the people who use it, we would love to talk.'
    cta: /contact
    cta_title: 'Start your project'
    cta_classes: button--primary
    book_appointment: false
    cta_2_title: 'Book a meeting'
    cta_2_classes: button--light-blue
    book_appointment_2: true
    illustration: julius-ipad.svg
    type: cta_block
    enabled: true
---
