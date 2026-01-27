# Filament Theme Options - RadarLeb Brand

## Option 1: Light Theme

**Primary Colors:**
- Primary: `#66afdb` (rgb(102, 175, 219)) - RadarLeb blue/cyan
- Background: Light gray/white
- Text: Dark gray on light
- Accents: Subtle blue tones

**Characteristics:**
- Clean, professional
- High contrast
- Modern flat design
- Daytime-friendly

## Option 2: Dark Theme (RECOMMENDED)

**Primary Colors:**
- Primary: `#6bbace` (rgb(107, 186, 206)) - RadarLeb blue/cyan
- Background: Dark slate (not pure black)
- Accents: `#ff7676` (rgb(255, 118, 118)) - RadarLeb red
- Text: Light on dark

**Characteristics:**
- Matches RadarLeb game aesthetic
- Modern dark UI
- Brand-consistent
- Eye-friendly for extended use

## Implementation

Both options use the same color palette but with different default theme modes:
- Light: `defaultThemeMode(ThemeMode::Light)`
- Dark: `defaultThemeMode(ThemeMode::Dark)`

The color palette supports both light and dark modes automatically via Filament's theming system.

