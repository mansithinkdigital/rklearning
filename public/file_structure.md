# Public Directory Structure

This directory contains the public-facing assets and the entry point for the application.

## Directory Tree

```text
public/
├── index.php
├── .htaccess
├── favicon.ico
├── robots.txt
├── assets/
│   ├── certificate/
│   │   ├── Asset 6-100.jpg
│   │   ├── Authorized Sign.jpg
│   │   ├── Certificate Blank.jpeg
│   │   ├── Certificate-template.jpeg
│   │   ├── Director.jpg
│   │   ├── ISO LOGO.jpg
│   │   ├── Rk Logo.jpg
│   │   ├── bg-sertificate.jpeg
│   │   ├── certificate border.png
│   │   ├── certificate-assets.zip
│   │   ├── certificate.png
│   │   ├── digital-india-IAF-Org-stamp.jpg
│   │   └──  certificate.pdf
│   └── images/
│       ├── course1.png
│       ├── hero.png
│       ├── logo.png
│       └── client/
├── admin/
│   ├── asset/
│   │   ├── favicons/
│   │   │   └── favicon.png
│   │   └── logo/
│   │       └── rk_logo.webp
│   └── uploads/
│       ├── courseimg/
│       ├── coursepackage/
│       ├── freepdf/
│       ├── galleryimg/
│       ├── material/
│       ├── paidpdf/
│       ├── receipt/
│       └── testimonialimg/
└── student/
    ├── asset/
    │   └── logo/
    │       ├── 1.png
    │       ├── iso_md_assets.png
    │       ├── msme-logo.webp
    │       ├── rksign.png
    │       └── rlstamp.png
    └── uploads/
        └── registerimg/
            ├── 1776059230_69dc835e3e581.jpg
            ├── 1777025462_69eb41b6dc215.png
            └── 1777270409_69eefe891e7ef.png
```

## Usage for Frontend Developers

- **Images**: Reference general images using `/assets/images/filename.ext`.
- **Certificates**: Reference certificate assets using `/assets/certificate/filename.ext`.
- **Admin/Student Uploads**: Reference dynamically uploaded files via `/admin/uploads/` or `/student/uploads/` if applicable.
