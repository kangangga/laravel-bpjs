import { defaultTheme, defineUserConfig } from "vuepress";
import { shikiPlugin } from "@vuepress/plugin-shiki";
import { searchPlugin } from "@vuepress/plugin-search";
import { getDirname, path } from "@vuepress/utils";
import { sidebar } from "../sidebar";

const __dirname = getDirname(import.meta.url);

export default defineUserConfig({
    base: "/laravel-bpjs/",
    lang: "id-ID",
    title: "Laravel BPJS",
    description: "Just playing around",
    plugins: [
        // nprogressPlugin(),
        // backToTopPlugin(),
        shikiPlugin({
            // theme: "hc_light",
        }),
        searchPlugin({
            locales: {
                "/": {
                    placeholder: "Search",
                },
            },
        }),
    ],
    theme: defaultTheme({
        colorMode: "dark",
        sidebar,
    }),
});
