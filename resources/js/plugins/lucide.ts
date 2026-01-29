import * as LucideIcons from 'lucide-vue-next';

export function registerLucideIcons(app: any) {
  for (const [name, component] of Object.entries(LucideIcons)) {
    app.component(`Lucide${name}`, component);
  }
}
