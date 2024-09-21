FROM ubuntu:latest
LABEL authors="deniskorablev"

ENTRYPOINT ["top", "-b"]