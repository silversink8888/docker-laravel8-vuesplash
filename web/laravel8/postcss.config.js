module.exports = (ctx) => {
  return {
    plugins: {
      tailwindcss: {},
      autoprefixer: {},
      cssnano: ctx.evv === "production" ? {}: false,
    },
  }
}
