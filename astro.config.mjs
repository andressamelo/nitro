import tailwind from "@astrojs/tailwind";
import path from 'path';
import icon from "astro-icon";
import { defineConfig } from "astro/config";


// https://astro.build/config
export default defineConfig({
  site: 'https://nitroag.com',
  integrations: [tailwind(), icon()],
  vite: {
  resolve: {
    alias: {
      '~': path.resolve('./src'),
    },
  },
  },
});


