module.exports = {
  multipass: true,
  plugins: [
    "preset-default",
    { name: "removeDimensions", active: true },
    { name: "removeViewBox", active: false } // viewBox нужно оставить!
  ]
};