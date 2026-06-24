---
id: support
blueprint: page
title: Support
meta_title: 'Website Support & Hosting Plans Portsmouth | We Are Jungle'
meta_description: 'Monthly website support and maintenance. 24/7 uptime monitoring, security updates, and development hours included. No long-term contracts.'
template: default
page_builder:
  -
    id: support_hero_01
    above_title: Support Plans
    above_title_variant: above-title--secondary
    title: 'Your Website. Looked After.'
    text:
      -
        type: paragraph
        content:
          -
            type: text
            text: "We don't disappear after launch. From monthly updates and monitoring to ongoing development support, our plans keep your website looked after - secure, fast, and moving forward."
    type: text_hero
    enabled: true
  -
    id: support_split_stats_01
    title: 'Proactive Support, Not Just Reactive Fixes'
    text:
      -
        type: paragraph
        content:
          -
            type: text
            text: "We monitor your site around the clock so issues are caught before they affect your visitors. From plugin updates and security patches to content tweaks and performance checks - we handle it all."
    stats:
      -
        id: stat_sup_01
        number: 24/7
        label: 'Uptime monitoring'
        type: new_set
        enabled: true
      -
        id: stat_sup_02
        number: '72'
        label: 'Day post-launch warranty'
        type: new_set
        enabled: true
      -
        id: stat_sup_03
        number: '30'
        label: 'Day rolling contracts'
        type: new_set
        enabled: true
    cta_title: 'Book a Call'
    book_appointment: true
    cta_classes: button--primary
    type: split_stats
    enabled: true
  -
    id: pricing_01
    above_title: Support
    title: 'Choose Your Support Plan'
    text:
      -
        type: paragraph
        content:
          -
            type: text
            text: "We don't disappear after launch. From monthly updates and monitoring to ongoing development support, our plans are built to keep your website secure, fast, and moving forward. Whether you need peace of mind or a dedicated digital partner, we've got a plan that fits."
    plans:
      -
        id: plan_ess
        name: Essentials
        price: '190'
        price_period: /mo
        vat_note: '+ VAT · 2 hrs support at £95/hr'
        description: 'Peace of mind for smaller sites that just need to stay secure and online.'
        featured: false
        features:
          -
            id: feat_e1
            label: '2 hours of support per month'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_e2
            label: 'Plugin & theme updates'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_e3
            label: 'Uptime monitoring (24/7)'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_e4
            label: 'Monthly status report'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_e5
            label: 'Minor theme tweaks'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_e6
            label: 'Priority response'
            included: false
            type: new_set
            enabled: true
          -
            id: feat_e7
            label: 'Performance & SEO check'
            included: false
            type: new_set
            enabled: true
        type: new_set
        enabled: true
      -
        id: plan_gro
        name: Growth
        price: '360'
        price_period: /mo
        vat_note: '+ VAT · 4 hrs support at £90/hr'
        description: 'Peace of mind for smaller sites that just need to stay secure and online.'
        featured: true
        features:
          -
            id: feat_g1
            label: '4 hours of support per month'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_g2
            label: 'Plugin & theme updates'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_g3
            label: 'Uptime monitoring (24/7)'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_g4
            label: 'Monthly status report'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_g5
            label: 'Minor theme tweaks'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_g6
            label: 'Priority response (next business day)'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_g7
            label: 'Quarterly performance & SEO check'
            included: true
            type: new_set
            enabled: true
        type: new_set
        enabled: true
      -
        id: plan_pri
        name: Priority
        price: '640'
        price_period: /mo
        vat_note: '+ VAT · 8 hrs support at £80/hr'
        description: 'Peace of mind for smaller sites that just need to stay secure and online.'
        featured: false
        features:
          -
            id: feat_p1
            label: '8 hours of support per month'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_p2
            label: 'Plugin & theme updates'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_p3
            label: 'Uptime monitoring (24/7)'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_p4
            label: 'Monthly status report'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_p5
            label: 'Theme tweaks & dev tasks'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_p6
            label: 'Priority response (same day)'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_p7
            label: 'Monthly performance & SEO check'
            included: true
            type: new_set
            enabled: true
        type: new_set
        enabled: true
    footnote: |-
      All plans cover WordPress, Shopify, and Statamic. Hours do not roll over. Additional hours billed at £95/hr + VAT.
      No long-term contracts; all support plans are on a 30-day rolling basis with 30 days' notice to cancel.
    type: pricing
    enabled: true
  -
    id: support_cta_01
    above_title: 'Get Started'
    title: "Not sure which plan is right for you?"
    text:
      -
        type: paragraph
        content:
          -
            type: text
            text: "Book a quick call and we'll walk you through the options. No pressure, just clarity."
    cta_title: 'Book a Call'
    book_appointment: true
    illustration: julius-ipad.svg
    type: cta_block
    enabled: true
author: 58fc95e0-3fe5-49b8-aa57-e8aa20e69afa
use_meta_keywords: false
no_index_page: false
no_follow_links: false
sitemap_priority: '0.5'
sitemap_changefreq: monthly
override_twitter_settings: false
updated_by: 58fc95e0-3fe5-49b8-aa57-e8aa20e69afa
updated_at: 1750187600
---
