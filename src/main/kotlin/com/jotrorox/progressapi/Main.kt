package com.jotrorox.progressapi

import io.ktor.server.routing.*
import java.awt.image.BufferedImage
import java.io.File
import javax.imageio.ImageIO

/**
 * Object that manages a cache of progress bar images.
 *
 * The cache is a map where the key is a string representation of the progress bar parameters
 * (percentage, width, and height), and the value is the generated progress bar image.
 *
 * If a progress bar image with the given parameters is not in the cache, the object tries to load it from disk.
 * If the image is not on disk, a new image is generated, saved to the cache, and saved to disk.
 */
object ProgressBarCache {
    private val cache = mutableMapOf<String, BufferedImage>()

    /**
     * Retrieves a progress bar image from the cache.
     *
     * If the image is not in the cache, tries to load it from disk.
     *
     * @param percentage The percentage of progress to be shown on the progress bar.
     * @param width The width of the progress bar.
     * @param height The height of the progress bar.
     * @return The cached progress bar image, or null if the image is not in the cache and not on disk.
     */
    fun get(percentage: Int, width: Int, height: Int): BufferedImage? {
        val key = "$percentage-$width-$height"
        return cache[key] ?: loadFromDisk(key)
    }

    /**
     * Adds a progress bar image to the cache and saves it to disk.
     *
     * @param percentage The percentage of progress to be shown on the progress bar.
     * @param width The width of the progress bar.
     * @param height The height of the progress bar.
     * @param image The progress bar image to add to the cache and save to disk.
     */
    fun put(percentage: Int, width: Int, height: Int, image: BufferedImage) {
        val key = "$percentage-$width-$height"
        cache[key] = image
        saveToDisk(key, image)
    }

    /**
     * Saves a progress bar image to disk.
     *
     * The image is saved as a PNG file. The file name is the string representation of the progress bar parameters.
     *
     * @param key The string representation of the progress bar parameters.
     * @param image The progress bar image to save.
     */
    private fun saveToDisk(key: String, image: BufferedImage) {
        val file = File("/path/to/cache/$key.png")
        ImageIO.write(image, "png", file)
    }

    /**
     * Loads a progress bar image from disk.
     *
     * The image is read from a PNG file. The file name is the string representation of the progress bar parameters.
     *
     * @param key The string representation of the progress bar parameters.
     * @return The loaded progress bar image, or null if the file does not exist.
     */
    private fun loadFromDisk(key: String): BufferedImage? {
        val file = File("/path/to/cache/$key.png")
        return if (file.exists()) {
            ImageIO.read(file)
        } else {
            null
        }
    }
}

/**
 * Generates a progress bar as a BufferedImage.
 *
 * This function first checks if a progress bar with the given parameters is already cached.
 * If it is, the cached image is returned. If it is not, a new progress bar image is generated,
 * cached, and then returned.
 *
 * The progress bar is a rectangle filled with black color up to the percentage of the width.
 * The rest of the rectangle is filled with white color.
 *
 * @param percentage The percentage of progress to be shown on the progress bar.
 * @param width The width of the progress bar.
 * @param height The height of the progress bar.
 * @return A BufferedImage representing the progress bar.
 */
fun generateProgressBar(percentage: Int, width: Int, height: Int): BufferedImage {
    ProgressBarCache.get(percentage, width, height)?.let { return it }

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

    ProgressBarCache.put(percentage, width, height, image)

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

}