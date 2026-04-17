# Landing Page Background Images Setup

## Instructions

Place your background images in the `/public/images/` directory:

1. **land1.jpg** - First background image (35% opacity in CSS)
2. **land2.jpg** - Second background image (35% opacity in CSS)

### Image Requirements:

- **Format**: JPG or PNG
- **Recommended Size**: 1920x1080px (16:9 ratio)
- **File Size**: Optimized for web (< 500KB each)
- **Purpose**: High-quality background images for the hero section

### Auto Cross-Fade Animation:

- Images automatically cross-fade every 5 seconds
- CSS animation uses 10-second cycle
- 35% opacity as specified in requirements
- Smooth transition overlay with dark gradient

## Example Images:

You can use stock images from:

- Unsplash: orphanage, children, education, community themes
- Pexels: similar themes
- Custom photos from your organization

## File Paths:

```
public/
├── images/
│   ├── land1.jpg      ← Place here
│   ├── land2.jpg      ← Place here
│   └── (other images)
└── index.php
```

## Testing:

After placing the images, visit the landing page to see the cross-fade animation in action.
