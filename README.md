# WordPress Photos Dump

A tool to analyze and manage photos from the WordPress Photo Directory.

## Features

### Photo Analysis
- List all photos with their metadata
- List photos by author
- List photos by category
- List photos by color
- List photos by orientation
- List photos by tag
- List photos without descriptions
- List photos without tags
- List photos without colors
- List photos without categories

### Data Management
- Synchronize photos from WordPress Photo Directory
- Update photos when they are modified
- Handle empty arrays as NULL in database
- Convert WebP images to JPG/JPEG when needed

### User Management
- List all authors
- Track orphan user IDs
- Link to WordPress admin and REST API for each user

## Database Structure

The tool uses SQLite with the following main table:

### Photos Table
- id: Photo ID
- slug: Photo slug
- date: Last modified date
- img_id: Featured media ID
- img_url: Image URL
- author: Author ID
- author_href: Author API URL
- categories: Serialized categories array (NULL if empty)
- colors: Serialized colors array (NULL if empty)
- orientations: Serialized orientations array (NULL if empty)
- tags: Serialized tags array (NULL if empty)
- content: Photo description

## API Integration

The tool uses the WordPress REST API to fetch photos with the following features:
- Orders photos by modification date
- Fetches 100 photos per page
- Includes all necessary fields for analysis
- Handles API pagination automatically

## Usage

1. Start the PHP built-in server:
```bash
php -S localhost:8000
```

2. Open your browser and navigate to:
```
http://localhost:8000/index.php
```

3. Use the navigation menu to:
   - Synchronize photos from WordPress
   - View different aspects of the photo collection
   - Check for missing metadata
   - Manage authors and track orphan users

## Notes

- Empty arrays are stored as NULL in the database
- WebP images are automatically converted to JPG/JPEG when needed
- Photos are synchronized based on their modification date
- Orphan users are tracked and can be linked to their REST API endpoints 