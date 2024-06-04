plugins {
    kotlin("jvm") version "1.9.23"
    application
}

group = "com.jotrorox"
version = "1.0"

repositories {
    mavenCentral()
}

dependencies {}

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