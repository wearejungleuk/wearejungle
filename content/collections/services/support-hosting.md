---
id: c8d9e0f1-0000-0000-0000-000000000008
blueprint: service
title: 'Support & Hosting'
meta_title: 'Website Support & Hosting Portsmouth | We Are Jungle'
meta_description: 'Monthly website support and hosting from We Are Jungle. 24/7 uptime monitoring, updates, security, and development hours. No long-term contracts.'
slug: support-hosting
card_text: 'Website care plans, secure hosting, and ongoing development support. We keep your site fast, secure, and running - so you can focus on your business.'
page_text: 'Most agencies build your site and then disappear. We do not. Our support plans keep your website in the best possible shape long after launch - routine updates, security monitoring, performance checks, and ongoing development hours when you need them. We treat your site as if it were our own, because our reputation depends on it staying that way.'
key_points:
  -
    id: kp_supp_01
    label: 'Monthly updates applied and tested before going live'
    type: new_set
    enabled: true
  -
    id: kp_supp_02
    label: '24/7 uptime monitoring with immediate response'
    type: new_set
    enabled: true
  -
    id: kp_supp_03
    label: 'Daily backups and ongoing security scanning'
    type: new_set
    enabled: true
  -
    id: kp_supp_04
    label: 'Development hours included for ongoing improvements'
    type: new_set
    enabled: true
icon: support.svg
page_builder:
  -
    id: services_hero_sh_01
    above_title: 'What We Do'
    title: 'Support & Hosting That Actually Has Your Back'
    text:
      -
        type: paragraph
        content:
          -
            type: text
            text: "We don't disappear after launch. From monthly updates and uptime monitoring to managed hosting and ongoing development support, we keep your website secure, fast, and moving forward - without you having to think about it."
    cta_title: 'Book a Call'
    book_appointment: true
    type: services_hero
    enabled: true
  -
    id: split_stats_sh_01
    title: "Website Support That Works While You Don't"
    text:
      -
        type: paragraph
        content:
          -
            type: text
            text: 'Most agencies build the site and walk away. We stick around. Our support plans are designed for businesses that need their website to stay online, stay secure, and keep improving - without having to manage it themselves.'
    stats:
      -
        id: stat_sh_01
        number: 50+
        label: 'Sites Currently Supported'
        type: new_set
        enabled: true
      -
        id: stat_sh_02
        number: 12+
        label: 'Years Experience'
        type: new_set
        enabled: true
      -
        id: stat_sh_03
        number: 24/7
        label: 'Uptime Monitoring'
        type: new_set
        enabled: true
    cta_title: 'Book a Call'
    book_appointment: true
    cta_classes: button--primary
    type: split_stats
    enabled: true
  -
    id: feature_cards_sh_01
    above_title: "What's Included"
    title: 'Everything Covered. Nothing Left to Chance.'
    text:
      -
        type: paragraph
        content:
          -
            type: text
            text: "Our support plans cover everything your website needs to stay healthy, secure, and performing - so you're not left scrambling when something goes wrong."
    cards:
      -
        id: fc_sh_01
        heading: 'Plugin & Theme Updates'
        card_text: 'We handle all updates as they come out - tested and applied carefully so nothing breaks without warning.'
        type: new_set
        enabled: true
        icon: page_quality.svg
      -
        id: fc_sh_02
        heading: '24/7 Uptime Monitoring'
        card_text: 'We watch your site around the clock. If it goes down, we know before you do - and we act immediately.'
        type: new_set
        enabled: true
        icon: web_monitoring.svg
      -
        id: fc_sh_03
        heading: 'Security & Backups'
        card_text: 'Daily backups, security scanning, and fast recovery if the worst happens. Your data is always protected.'
        type: new_set
        enabled: true
        icon: seo_monitoring.svg
      -
        id: fc_sh_04
        heading: 'Monthly Status Reports'
        card_text: "A clear summary of what's been done, what's performing, and what to keep an eye on - no jargon."
        type: new_set
        enabled: true
        icon: campaign.svg
      -
        id: fc_sh_05
        heading: 'Ongoing Development Hours'
        card_text: 'Need a new page, a tweak, or something bigger? Your support hours cover development work too - just ask.'
        type: new_set
        enabled: true
        icon: big-impact.svg
      -
        id: fc_sh_06
        heading: 'Performance & SEO Checks'
        card_text: 'We review your site speed and search performance regularly and flag anything worth improving.'
        type: new_set
        enabled: true
        icon: select_product.svg
    type: feature_cards
    enabled: true
    book_appointment: false
  -
    id: pricing_sh_01
    above_title: 'Support Plans'
    title: 'Support That Suits Your Business'
    text:
      -
        type: paragraph
        content:
          -
            type: text
            text: 'From essential maintenance to a full digital partner - choose the plan that fits. All plans are on a 30-day rolling basis with no long-term contracts.'
    plans:
      -
        id: plan_sh_ess
        name: Essentials
        price: '190'
        price_period: /mo
        vat_note: '+ VAT · 2 hrs support at £95/hr'
        description: 'Peace of mind for smaller sites that just need to stay secure and online.'
        featured: false
        features:
          -
            id: feat_sh_e1
            label: '2 hours of support per month'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_sh_e2
            label: 'Plugin & theme updates'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_sh_e3
            label: 'Uptime monitoring (24/7)'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_sh_e4
            label: 'Monthly status report'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_sh_e5
            label: 'Minor theme tweaks'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_sh_e6
            label: 'Priority response'
            included: false
            type: new_set
            enabled: true
          -
            id: feat_sh_e7
            label: 'Performance & SEO check'
            included: false
            type: new_set
            enabled: true
        type: new_set
        enabled: true
      -
        id: plan_sh_gro
        name: Growth
        price: '360'
        price_period: /mo
        vat_note: '+ VAT · 4 hrs support at £90/hr'
        description: 'Ideal for growing businesses that need reliable support and regular improvements.'
        featured: true
        features:
          -
            id: feat_sh_g1
            label: '4 hours of support per month'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_sh_g2
            label: 'Plugin & theme updates'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_sh_g3
            label: 'Uptime monitoring (24/7)'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_sh_g4
            label: 'Monthly status report'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_sh_g5
            label: 'Minor theme tweaks'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_sh_g6
            label: 'Priority response (next business day)'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_sh_g7
            label: 'Quarterly performance & SEO check'
            included: true
            type: new_set
            enabled: true
        type: new_set
        enabled: true
      -
        id: plan_sh_pri
        name: Priority
        price: '640'
        price_period: /mo
        vat_note: '+ VAT · 8 hrs support at £80/hr'
        description: 'A dedicated digital partner for businesses that need maximum support and fast turnaround.'
        featured: false
        features:
          -
            id: feat_sh_p1
            label: '8 hours of support per month'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_sh_p2
            label: 'Plugin & theme updates'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_sh_p3
            label: 'Uptime monitoring (24/7)'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_sh_p4
            label: 'Monthly status report'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_sh_p5
            label: 'Theme tweaks & dev tasks'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_sh_p6
            label: 'Priority response (same day)'
            included: true
            type: new_set
            enabled: true
          -
            id: feat_sh_p7
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
    id: reviews_sh_01
    title: 'The proof is in the praise'
    text:
      -
        type: paragraph
        content:
          -
            type: text
            text: "Don't just take our word for it. See how our work impacts the people who matter most."
    reviews:
      -
        id: reviews_sh_r01
        name: 'Jodie Goodchild'
        role: 'Known For'
        quote:
          -
            type: paragraph
            content:
              -
                type: text
                text: 'I was referred to We Are Jungle by someone I trust, and from the moment we met, I knew they were the real deal. '
              -
                type: hardBreak
              -
                type: hardBreak
              -
                type: text
                text: "I had a website before, but We Are Jungle turned it into something I'm truly proud of. The process felt effortless, and their expertise and approach made everything so easy."
        image:
          - image-3.png
        website: 'https://knownfor.co.uk'
        type: new_set
        enabled: true
      -
        id: reviews_sh_r02
        name: 'Cameron Brew'
        role: 'South Coast Rx Physiotherapy'
        quote:
          -
            type: paragraph
            content:
              -
                type: text
                text: 'Both Brad and Kay went above and beyond in their support for us and ensured that the final version of the website represented exactly the feel we were going for. Thank you so much to both of you for all of your hard work. We could not recommend We are Jungle highly enough!'
        image:
          - screenshot-2025-01-22-at-11.46.21-520x650.jpg
        website: 'https://southcoastrxphysiotherapy.co.uk'
        type: new_set
        enabled: true
    type: reviews
    enabled: true
  -
    id: calendly_sh_01
    title: 'Book an intro call about support'
    text:
      -
        type: paragraph
        content:
          -
            type: text
            text: "Not sure which plan is right for you? Book a quick call and we'll walk you through the options - no pressure, just clarity."
      -
        type: paragraph
        content:
          -
            type: text
            marks:
              -
                type: bold
            text: 'What to expect'
      -
        type: bulletList
        content:
          -
            type: listItem
            content:
              -
                type: text
                text: 'A look at your current site and what kind of support makes sense'
          -
            type: listItem
            content:
              -
                type: text
                text: 'A plain-English explanation of what each plan covers'
          -
            type: listItem
            content:
              -
                type: text
                text: 'Honest advice on what your site actually needs'
      -
        type: paragraph
        content:
          -
            type: text
            marks:
              -
                type: bold
            text: 'After the call'
      -
        type: bulletList
        content:
          -
            type: listItem
            content:
              -
                type: text
                text: "We'll recommend the right plan for your site and your budget"
          -
            type: listItem
            content:
              -
                type: text
                text: "You'll know exactly what's covered and what happens next"
          -
            type: listItem
            content:
              -
                type: text
                text: 'No pressure - just an honest conversation about what your site needs'
    cta_title: 'Book a Call'
    book_appointment: true
    type: calendly
    enabled: true
  -
    id: related_services_sh_01
    related_service_1: f8142c54-0000-0000-0000-000000000001
    related_service_2: 15b87cff-0000-0000-0000-000000000002
    type: related_services
    enabled: true
  -
    id: faq_accordion_sh_01
    above_title: 'Common Questions'
    title: 'Support & Hosting FAQs'
    items:
      -
        id: faq_sh_01
        question: 'What platforms do your support plans cover?'
        answer:
          -
            type: paragraph
            content:
              -
                type: text
                text: 'All plans cover WordPress, WooCommerce, Shopify, and Statamic. If your site is built on something else, get in touch and we can discuss what we can do.'
        type: new_set
        enabled: true
      -
        id: faq_sh_02
        question: 'Are there long-term contracts?'
        answer:
          -
            type: paragraph
            content:
              -
                type: text
                text: 'No. All support plans are on a 30-day rolling basis. You can cancel with 30 days notice at any time - no lock-ins, no penalties.'
        type: new_set
        enabled: true
      -
        id: faq_sh_03
        question: 'Do unused hours roll over to the next month?'
        answer:
          -
            type: paragraph
            content:
              -
                type: text
                text: "Hours don't roll over month to month. If you need more than your plan allows, additional hours are billed at £95/hr + VAT."
        type: new_set
        enabled: true
      -
        id: faq_sh_04
        question: 'What counts as a support hour?'
        answer:
          -
            type: paragraph
            content:
              -
                type: text
                text: 'Any work we do on your site - content updates, plugin updates, bug fixes, new pages, design tweaks, or development tasks. If we work on your site, we log the time.'
        type: new_set
        enabled: true
      -
        id: faq_sh_05
        question: 'What happens if my site goes down?'
        answer:
          -
            type: paragraph
            content:
              -
                type: text
                text: "We monitor all supported sites 24/7. If your site goes down, we're alerted immediately and act fast to get it back online - you'll hear from us before you notice the problem."
        type: new_set
        enabled: true
      -
        id: faq_sh_06
        question: 'Do you offer hosting as well as support?'
        answer:
          -
            type: paragraph
            content:
              -
                type: text
                text: 'Yes. We can host your site on fast, reliable managed hosting as part of your support arrangement. If you already have hosting, we can work alongside your existing provider.'
        type: new_set
        enabled: true
      -
        id: faq_sh_07
        question: 'Can I upgrade or downgrade my plan?'
        answer:
          -
            type: paragraph
            content:
              -
                type: text
                text: 'Yes. Plans can be changed with 30 days notice. If your needs change, just let us know and we will move you to the right plan.'
        type: new_set
        enabled: true
      -
        id: faq_sh_08
        question: 'Do you support sites you did not build?'
        answer:
          -
            type: paragraph
            content:
              -
                type: text
                text: "Yes - we support sites built by other agencies too. We'll review your site first to make sure we're comfortable taking it on, then onboard you onto the right plan."
        type: new_set
        enabled: true
    type: faq_accordion
    enabled: true
  -
    id: cta_block_sh_01
    above_title: 'Support & Hosting'
    title: "Don't Wait for Something to Break"
    text:
      -
        type: paragraph
        content:
          -
            type: text
            text: "Most businesses only think about website support when something goes wrong. Get ahead of it - book a call and let's set up a plan that keeps you covered."
    cta_title: 'Book a Call'
    book_appointment: true
    illustration: julius-ipad.svg
    type: cta_block
    enabled: true
    book_appointment_2: false
use_meta_keywords: false
no_index_page: false
no_follow_links: false
sitemap_priority: '0.5'
sitemap_changefreq: daily
override_twitter_settings: false
updated_by: 58fc95e0-3fe5-49b8-aa57-e8aa20e69afa
updated_at: 1781867667
---
