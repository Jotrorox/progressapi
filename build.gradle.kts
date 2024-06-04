plugins {
    kotlin("jvm") version "1.9.23"
    application

    id("io.ktor.plugin") version "2.3.11"
}

group = "com.jotrorox"
version = "1.0"

repositories {
    mavenCentral()
}

dependencies {
    // The Ktor server dependencies
    implementation("io.ktor:ktor-server-core")
    implementation("io.ktor:ktor-server-netty")

    // The Logging framework
    implementation("ch.qos.logback:logback-classic:1.5.6")
}

application {
    mainClass.set("com.jotrorox.progressapi.MainKt")
}

kotlin {
    jvmToolchain(21)
}

tasks.withType<Jar> {
    manifest {
        attributes["Main-Class"] = "com.jotrorox.progressapi.MainKt"
    }
    duplicatesStrategy = DuplicatesStrategy.EXCLUDE
    from(sourceSets.main.get().output)
    dependsOn(configurations.runtimeClasspath)
    from({
        configurations.runtimeClasspath.get().filter { it.name.endsWith("jar") }.map { zipTree(it) }
    })
}