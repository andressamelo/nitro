import tailwind from "@astrojs/tailwind";
import icon from "astro-icon";
import { defineConfig } from "astro/config";


export default defineConfig({
  site: 'https://nitroag.com',
  integrations: [tailwind(), icon()],
});

