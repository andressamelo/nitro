import tailwind from "@astrojs/tailwind";
import icon from "astro-icon";
import path from 'path';
import { defineConfig } from "astro/config";


export default defineConfig({
  site: 'https://nitroag.com',
  integrations: [tailwind(), icon()],
    vite: {
    resolve: {
      alias: {
        '@components': path.resolve('./src/components'),
      },
    },
  },
});


