package com.jotrorox

import java.awt.image.BufferedImage
import java.io.File
import javax.imageio.ImageIO

/**
 * Generates a progress bar image.
 *
 * @param percentage The percentage of the progress bar to fill.
 * @param width The width of the progress bar.
 * @param height The height of the progress bar.
 * @return The generated progress bar image.
 */
fun generateProgressBar(percentage: Int, width: Int, height: Int): BufferedImage {
    val image = BufferedImage(width, height, BufferedImage.TYPE_INT_RGB)
    val g2d = image.createGraphics()
    g2d.setRenderingHint(
        java.awt.RenderingHints.KEY_ANTIALIASING,
        java.awt.RenderingHints.VALUE_ANTIALIAS_ON
    )
    g2d.color = java.awt.Color.WHITE
    g2d.fillRect(0, 0, width, height)
    g2d.color = java.awt.Color.BLACK
    g2d.fillRect(0, 0, (width * percentage / 100.0).toInt(), height)
    g2d.dispose()
    return image
}

/**
 * Saves an image to a file.
 *
 * @param image The image to save.
 * @param path The path to save the image to.
 * @throws NullPointerException If the Path to the image is null.
 * @throws IllegalArgumentException If the image is null.
 * @throws IOException If an error during writing occurs.
 */
fun saveImage(image: BufferedImage, path: String) {
    val file = File(path)
    ImageIO.write(image, "png", file)
}

fun main() {
    println("Hello World!")
}